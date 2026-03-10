<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = BarangMasuk::with(['barang', 'user'])->latest();

        if ($search) {
            $query->whereHas('barang', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('factory', 'like', "%{$search}%");
            });
        }

        $barangMasuks = $query->paginate(10);
        $barangs = \App\Models\Barang::with('barangMasuks')->get(); // Untuk dropdown dan load foto lama

        return view('admin.barang-masuk.index', compact('barangMasuks', 'barangs'));
    }

    public function create()
    {
        // View create di-handle via modal di index
    }

    public function store(Request $request)
    {
        $request->validate([
            'incoming_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'is_new_barang' => 'required|boolean',
            // Validasi jika barang baru
            'sku' => 'required_if:is_new_barang,1|unique:barangs,sku|nullable|string',
            'name' => 'required_if:is_new_barang,1|nullable|string',
            'factory' => 'nullable|string',
            'merek' => 'nullable|string',
            'unit' => 'required_if:is_new_barang,1|nullable|string',
            'purchase_price' => 'required_if:is_new_barang,1|nullable|numeric',
            'selling_price' => 'required_if:is_new_barang,1|nullable|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // Validasi jika barang lama
            'barang_id' => 'required_if:is_new_barang,0|nullable|exists:barangs,id',
            'deleted_old_images' => 'nullable|array',
            'deleted_old_images.*' => 'string'
        ]);

        $barangId = $request->barang_id;
        $imagePaths = [];

        // Upload images jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('barang_images', 'public');
                $imagePaths[] = $path;
            }
        }

        if ($request->is_new_barang) {
            // Generate Barcode SVG
            $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();
            $barcodeSvg = $generator->getBarcode($request->sku, $generator::TYPE_CODE_128);
            
            // Simpan file SVG
            $barcodeFileName = 'barcodes/' . $request->sku . '.svg';
            \Illuminate\Support\Facades\Storage::disk('public')->put($barcodeFileName, $barcodeSvg);

            // Buat Barang baru
            $barang = \App\Models\Barang::create([
                'sku' => $request->sku,
                'name' => $request->name,
                'factory' => $request->factory,
                'merek' => $request->merek,
                'unit' => $request->unit,
                'purchase_price' => $request->purchase_price,
                'selling_price' => $request->selling_price,
                'stock' => $request->quantity,
                'barcode_path' => $barcodeFileName,
                'user_id' => auth()->id(),
            ]);
            $barangId = $barang->id;
        } else {
            // Update stok barang lama
            $barang = \App\Models\Barang::findOrFail($barangId);
            $barang->increment('stock', $request->quantity);

            // Proses hapus foto lama jika ada checkbox / array string deleted_old_images
            if ($request->has('deleted_old_images') && is_array($request->deleted_old_images)) {
                $bms = BarangMasuk::where('barang_id', $barangId)->get();
                foreach ($request->deleted_old_images as $deletedPath) {
                    // Cari di db barang masuk
                    foreach ($bms as $bm) {
                        $imgs = is_string($bm->images) ? json_decode($bm->images, true) : $bm->images;
                        if (is_string($imgs)) current(json_decode($imgs, true) ?? []); // handle double encode if exists
                        
                        if (is_array($imgs) && in_array($deletedPath, $imgs)) {
                            // buang dari array
                            $imgs = array_values(array_diff($imgs, [$deletedPath]));
                            $bm->update(['images' => empty($imgs) ? null : $imgs]);
                            
                            // Hapus fisik
                            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($deletedPath)) {
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($deletedPath);
                            }
                        }
                    }
                }
            }
        }

        // Catat Barang Masuk
        BarangMasuk::create([
            'barang_id' => $barangId,
            'user_id' => auth()->id(),
            'incoming_date' => $request->incoming_date,
            'quantity' => $request->quantity,
            'images' => empty($imagePaths) ? null : $imagePaths,
        ]);

        return back()->with('success', 'Data barang masuk berhasil ditambahkan.');
    }

    public function show(BarangMasuk $barangMasuk)
    {
        //
    }

    public function edit(BarangMasuk $barangMasuk)
    {
        // View edit di-handle via modal
    }

    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $request->validate([
            'incoming_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deleted_old_images' => 'nullable|array',
            'deleted_old_images.*' => 'string'
        ]);

        // Hitung selisih qty lama dan baru untuk stok
        $diff = $request->quantity - $barangMasuk->quantity;

        $imagePaths = is_string($barangMasuk->images) ? json_decode($barangMasuk->images, true) : ($barangMasuk->images ?? []);
        if (is_string($imagePaths)) $imagePaths = json_decode($imagePaths, true) ?? [];

        // Hapus foto lama yang ditandai untuk dihapus
        if ($request->has('deleted_old_images') && is_array($request->deleted_old_images)) {
            foreach ($request->deleted_old_images as $deletedPath) {
                if (in_array($deletedPath, $imagePaths)) {
                    $imagePaths = array_values(array_diff($imagePaths, [$deletedPath]));
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($deletedPath)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($deletedPath);
                    }
                }
            }
        }

        // Tambah upload gambar baru jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('barang_images', 'public');
                $imagePaths[] = $path;
            }
        }

        $barangMasuk->update([
            'incoming_date' => $request->incoming_date,
            'quantity' => $request->quantity,
            'images' => empty($imagePaths) ? null : $imagePaths,
        ]);

        // Update stok barang utama
        $barangMasuk->barang->increment('stock', $diff);

        return back()->with('success', 'Data barang masuk berhasil diperbarui.');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        $barang = $barangMasuk->barang;
        
        // Hapus gambar fisik
        if ($barangMasuk->images) {
            foreach ($barangMasuk->images as $oldPath) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
                }
            }
        }

        $qty = $barangMasuk->quantity;
        $barangMasuk->delete();

        // Kembalikan stok - biarkan Barang tetap hidup (0) meskipun tidak ada riwayat BarangMasuk lagi
        $barang->decrement('stock', $qty);

        return back()->with('success', 'Data barang masuk berhasil dihapus.');
    }
}
