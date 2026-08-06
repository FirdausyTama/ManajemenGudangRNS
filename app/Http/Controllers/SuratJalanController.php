<?php

namespace App\Http\Controllers;

use App\Models\SuratJalan;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SuratJalanController
{
    // Fungsi untuk menampilkan riwayat Surat Jalan (pengiriman) di halaman admin
    public function index(Request $request)
    {
        $period = $request->input('period');
        $date = $request->input('date');
        $search = $request->input('search');

        $query = SuratJalan::with(['penjualan', 'user'])->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat_jalan', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%");
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_surat_jalan', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('month')) {
            $monthParts = explode('-', $request->month);
            if (count($monthParts) == 2) {
                $query->whereYear('tanggal_surat_jalan', $monthParts[0])
                      ->whereMonth('tanggal_surat_jalan', $monthParts[1]);
            }
        }

        $suratJalans = $query->paginate(10)->withQueryString();
        $penjualans = Penjualan::with('items.barang')->latest()->get();

        return view('admin.surat_jalan.index', compact('suratJalans', 'penjualans'));
    }

    // Fungsi untuk menyimpan data Surat Jalan baru dari proses pengiriman
    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'nullable|exists:penjualans,id',
            'tanggal_surat_jalan' => 'required|date',
            'nama_pengirim' => 'required|string',
            'nama_penerima' => 'required|string',
            'telp_penerima' => 'required|string',
            'alamat_penerima' => 'required|string',
            'nama_barang_jasa' => 'required|string',
            'qty' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        // Generate Nomor Surat Jalan: XX/SJ/RNS-[Month]/[Year]
        $year = date('Y', strtotime($request->tanggal_surat_jalan));
        $month = date('n', strtotime($request->tanggal_surat_jalan));
        $romanMonths = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        
        $count = SuratJalan::whereYear('tanggal_surat_jalan', $year)
                            ->whereMonth('tanggal_surat_jalan', $month)
                            ->count() + 1;
        $nomor = str_pad($count, 2, '0', STR_PAD_LEFT) . '/SJ/RNS-' . $romanMonths[$month] . '/' . $year;

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
            'jumlah' => $request->jumlah ?? 0,
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
