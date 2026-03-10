<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Penjualan::with(['items.barang', 'user'])->latest();

        if ($search) {
            $query->where('no_transaksi', 'like', "%{$search}%")
                  ->orWhere('nama_customer', 'like', "%{$search}%");
        }

        $penjualans = $query->paginate(10);
        $barangs = Barang::all();

        return view('admin.penjualan.index', compact('penjualans', 'barangs'));
    }

    public function show(Penjualan $penjualan)
    {
        $penjualan->load(['items.barang', 'user']);
        return view('admin.penjualan.show', compact('penjualan'));
    }

    public function printInvoice(Request $request, Penjualan $penjualan)
    {
        $penjualan->load(['items.barang', 'user']);
        $penandatangan = $request->query('penandatangan', 'Admin');
        return view('admin.penjualan.print-invoice', compact('penjualan', 'penandatangan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required|string',
            'alamat_customer' => 'nullable|string',
            'no_hp_customer' => 'nullable|string',
            'tanggal_transaksi' => 'required|date',
            'status_pembayaran' => 'required|in:lunas,belum lunas,cicilan',
            'is_ongkir_aktif' => 'nullable|boolean',
            'berat_total' => 'nullable|numeric|min:0',
            'harga_per_kg' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.kuantitas' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Generate No Transaksi
            $year = date('Y');
            $latestTrx = Penjualan::whereYear('created_at', $year)->latest('id')->first();
            $nextId = $latestTrx ? $latestTrx->id + 1 : 1;
            $no_transaksi = 'TRX-' . $year . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            // Hitung ongkir
            $isOngkirAktif = $request->boolean('is_ongkir_aktif');
            $beratTotal = $isOngkirAktif ? ($request->berat_total ?? 0) : null;
            $hargaPerKg = $isOngkirAktif ? ($request->harga_per_kg ?? 0) : null;
            $totalOngkir = $isOngkirAktif ? ($beratTotal * $hargaPerKg) : 0;

            $penjualan = Penjualan::create([
                'no_transaksi' => $no_transaksi,
                'nama_customer' => $request->nama_customer,
                'alamat_customer' => $request->alamat_customer,
                'no_hp_customer' => $request->no_hp_customer,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'status_pembayaran' => $request->status_pembayaran,
                'is_ongkir_aktif' => $isOngkirAktif,
                'berat_total' => $beratTotal,
                'harga_per_kg' => $hargaPerKg,
                'total_ongkir' => $totalOngkir,
                'total_keseluruhan' => 0, // Akan ditambahkan harga barang di bawah
                'user_id' => auth()->id()
            ]);

            $total_keseluruhan = $totalOngkir;

            foreach ($request->items as $itemData) {
                $barang = Barang::findOrFail($itemData['barang_id']);
                
                // Cek stok
                if ($barang->stock < $itemData['kuantitas']) {
                    throw new \Exception("Stok barang {$barang->name} tidak mencukupi. Sisa: {$barang->stock}. Diminta: {$itemData['kuantitas']}");
                }

                $total_harga = $itemData['kuantitas'] * $itemData['harga_satuan'];
                $total_keseluruhan += $total_harga;

                PenjualanItem::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $barang->id,
                    'kuantitas' => $itemData['kuantitas'],
                    'harga_satuan' => $itemData['harga_satuan'],
                    'total_harga' => $total_harga
                ]);

                // Kurangi stok barang
                $barang->decrement('stock', $itemData['kuantitas']);
            }

            $penjualan->update(['total_keseluruhan' => $total_keseluruhan]);

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan penjualan: ' . $e->getMessage())->withInput();
        }
    }

    public function updateStatus(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:lunas,belum lunas,cicilan',
        ]);

        $penjualan->update([
            'status_pembayaran' => $request->status_pembayaran
        ]);

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function destroy(Penjualan $penjualan)
    {
        DB::beginTransaction();
        try {
            // Restore stok barangs
            foreach ($penjualan->items as $item) {
                if ($item->barang) {
                    $item->barang->increment('stock', $item->kuantitas);
                }
            }

            $penjualan->delete(); // automatically cascades deletes to items based on DB migration

            DB::commit();
            return back()->with('success', 'Data penjualan berhasil dihapus dan stok barang telah dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus penjualan: ' . $e->getMessage());
        }
    }
}
