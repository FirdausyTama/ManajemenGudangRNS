<?php

namespace App\Http\Controllers;

use App\Models\SuratJalan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratJalanController
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter', 'Semua Waktu');

        $query = SuratJalan::with(['penjualan', 'user'])->latest();

        if ($search) {
            $query->where('nomor_surat_jalan', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%");
        }

        if ($filter == 'Hari Ini') {
            $query->whereDate('tanggal_surat_jalan', today());
        } elseif ($filter == 'Minggu Ini') {
            $query->whereBetween('tanggal_surat_jalan', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter == 'Bulan Ini') {
            $query->whereMonth('tanggal_surat_jalan', now()->month)
                  ->whereYear('tanggal_surat_jalan', now()->year);
        }

        $suratJalans = $query->paginate(10);
        $penjualans = Penjualan::latest()->get();

        return view('admin.surat_jalan.index', compact('suratJalans', 'penjualans', 'filter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|exists:penjualans,id',
            'tanggal_surat_jalan' => 'required|date',
            'nama_pengirim' => 'required|string',
            'nama_penerima' => 'required|string',
            'telp_penerima' => 'required|string',
            'alamat_penerima' => 'required|string',
            'nama_barang_jasa' => 'required|string',
            'qty' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $year = date('Y', strtotime($request->tanggal_surat_jalan));
        $latest = SuratJalan::whereYear('tanggal_surat_jalan', $year)->latest('id')->first();
        $nextId = $latest ? $latest->id + 1 : 1;
        $nomor = 'SJ/' . str_pad($nextId, 3, '0', STR_PAD_LEFT) . '/RNS/' . $year;

        SuratJalan::create([
            'nomor_surat_jalan' => $nomor,
            'penjualan_id' => $request->penjualan_id,
            'tanggal_surat_jalan' => $request->tanggal_surat_jalan,
            'nama_pengirim' => $request->nama_pengirim,
            'nama_penerima' => $request->nama_penerima,
            'telp_penerima' => $request->telp_penerima,
            'alamat_penerima' => $request->alamat_penerima,
            'nama_barang_jasa' => $request->nama_barang_jasa,
            'qty' => $request->qty,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Surat Jalan berhasil dibuat dan disimpan.');
    }

    public function print(SuratJalan $surat_jalan)
    {
        $surat_jalan->load(['penjualan', 'user']);
        return view('admin.surat_jalan.print', compact('surat_jalan'));
    }

    public function destroy(SuratJalan $surat_jalan)
    {
        $surat_jalan->delete();
        return back()->with('success', 'Surat Jalan berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        SuratJalan::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true]);
    }
}
