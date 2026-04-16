<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MonitoringStokController
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        
        $query = Barang::with('user')->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('factory', 'like', "%{$search}%");
            });
        }

        if ($status) {
            if ($status === 'tersedia') {
                $query->where('stock', '>=', 10);
            } elseif ($status === 'menipis') {
                $query->where('stock', '>', 0)->where('stock', '<', 10);
            } elseif ($status === 'habis') {
                $query->where('stock', '<=', 0);
            }
        }

        $barangs = $query->paginate(12)->withQueryString();

        // Calculate Global Statistics
        $stats = [
            'total_stok' => Barang::sum('stock'),
            'total_barang' => Barang::count(),
            'stok_tersedia' => Barang::where('stock', '>=', 10)->count(),
            'stok_menipis' => Barang::where('stock', '>', 0)->where('stock', '<', 10)->count(),
            'stok_habis' => Barang::where('stock', '<=', 0)->count(),
        ];

        return view('admin.monitoring-stok.index', compact('barangs', 'stats'));
    }

    public function scan(Request $request)
    {
        $sku = $request->input('sku');
        $barang = Barang::with(['barangMasuks.user', 'user'])->where('sku', $sku)->first();

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

    public function printBarcode(Request $request, Barang $barang)
    {
        $qty = max(1, min(500, (int) $request->query('qty', 1)));
        return view('admin.monitoring-stok.print-barcode', compact('barang', 'qty'));
    }

    public function destroy(Request $request, $id)
    {
        if (auth()->user()->role !== 'owner') {
            return back()->with('error', 'Hanya Owner yang diperbolehkan untuk menghapus data barang.');
        }

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return back()->with('error', 'Password yang Anda masukkan salah. Penghapusan dibatalkan.');
        }

        $barang = Barang::findOrFail($id);
        
        // Hapus barcode image dari storage jika ada
        if ($barang->barcode_path && Storage::disk('public')->exists($barang->barcode_path)) {
            Storage::disk('public')->delete($barang->barcode_path);
        }

        // Karena kita menggunakan cascade on delete di migration-nya, 
        // menghapus parent Barang akan otomatis menghapus semua BarangMasuk-nya.
        // Tapi mari kita pastikan foto-fotonya juga terhapus jika diperlukan,
        // (atau biarkan jika kita percaya pada Storage Cleaning nantikan)
        
        $barangMasuks = BarangMasuk::where('barang_id', $barang->id)->get();
        foreach($barangMasuks as $bm) {
            $images = $bm->images;
            if (is_string($images)) $images = json_decode($images, true);
            
            if (is_array($images)) {
                foreach ($images as $img) {
                    if (Storage::disk('public')->exists($img)) {
                        Storage::disk('public')->delete($img);
                    }
                }
            }
        }

        $barang->delete();

        return redirect()->route('monitoring-stok.index')->with('success', 'Barang berhasil dihapus secara permanen beserta semua riwayat stoknya.');
    }
}
