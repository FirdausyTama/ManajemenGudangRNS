<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringStokController
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = \App\Models\Barang::with('user')->latest();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('factory', 'like', "%{$search}%");
        }

        $barangs = $query->paginate(12);

        return view('admin.monitoring-stok.index', compact('barangs'));
    }

    public function scan(Request $request)
    {
        $sku = $request->input('sku');
        $barang = \App\Models\Barang::with(['barangMasuks', 'user'])->where('sku', $sku)->first();

        if ($barang) {
            return response()->json([
                'success' => true,
                'data' => $barang
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Barang dengan SKU/Barcode tersebut tidak ditemukan.'
        ], 404);
    }

    public function printBarcode(Request $request, \App\Models\Barang $barang)
    {
        $qty = max(1, min(500, (int) $request->query('qty', 1)));
        return view('admin.monitoring-stok.print-barcode', compact('barang', 'qty'));
    }

    public function destroy(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if (!\Illuminate\Support\Facades\Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', 'Password yang Anda masukkan salah. Penghapusan dibatalkan.');
        }

        $barang = \App\Models\Barang::findOrFail($id);
        
        // Hapus barcode image dari storage jika ada
        if ($barang->barcode_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($barang->barcode_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($barang->barcode_path);
        }

        // Karena kita menggunakan cascade on delete di migration-nya, 
        // menghapus parent Barang akan otomatis menghapus semua BarangMasuk-nya.
        // Tapi mari kita pastikan foto-fotonya juga terhapus jika diperlukan,
        // (atau biarkan jika kita percaya pada Storage Cleaning nantikan)
        
        $barangMasuks = \App\Models\BarangMasuk::where('barang_id', $barang->id)->get();
        foreach($barangMasuks as $bm) {
            $images = $bm->images;
            if (is_string($images)) $images = json_decode($images, true);
            
            if (is_array($images)) {
                foreach ($images as $img) {
                    if (\Illuminate\Support\Facades\Storage::disk('public')->exists($img)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($img);
                    }
                }
            }
        }

        $barang->delete();

        return redirect()->route('monitoring-stok.index')->with('success', 'Barang berhasil dihapus secara permanen beserta semua riwayat stoknya.');
    }
}
