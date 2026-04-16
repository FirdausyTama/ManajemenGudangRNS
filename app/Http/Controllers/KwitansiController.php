<?php

namespace App\Http\Controllers;

use App\Models\Kwitansi;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KwitansiController
{
    public function index(Request $request)
    {
        $period = $request->input('period');
        $date = $request->input('date');
        $search = $request->input('search');

        $query = Kwitansi::with(['penjualan', 'user'])->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nomor_kwitansi', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%");
            });
        }

        if ($date) {
            $query->whereDate('tanggal_kwitansi', $date);
        } elseif ($period) {
            $now = Carbon::now();
            if ($period === 'today') {
                $query->whereDate('tanggal_kwitansi', $now->toDateString());
            } elseif ($period === 'week') {
                $query->whereBetween('tanggal_kwitansi', [$now->startOfWeek()->toDateString(), $now->endOfWeek()->toDateString()]);
            } elseif ($period === 'month') {
                $query->whereMonth('tanggal_kwitansi', $now->month)
                      ->whereYear('tanggal_kwitansi', $now->year);
            } elseif ($period === 'year') {
                $query->whereYear('tanggal_kwitansi', $now->year);
            }
        }

        $kwitansis = $query->paginate(10)->withQueryString();
        $penjualans = Penjualan::latest()->get(); // For manual select

        return view('admin.kwitansi.index', compact('kwitansis', 'penjualans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|exists:penjualans,id',
            'tanggal_kwitansi' => 'required|date',
            'penandatangan' => 'required|string',
            'nama_penerima' => 'required|string',
            'alamat_penerima' => 'required|string',
            'total_bilangan' => 'nullable|string',
            'keterangan' => 'required|string',
            'total_pembayaran' => 'required|numeric',
        ]);

        $nomor_kwitansi = Kwitansi::generateNumber($request->tanggal_kwitansi);

        // Auto Terbilang Logic
        $bilangan = $request->total_bilangan;
        if (empty($bilangan) || $bilangan === '(Silakan Edit Nanti Jika Perlu)') {
            $bilangan = $this->terbilang($request->total_pembayaran) . ' Rupiah';
        }

        Kwitansi::create([
            'nomor_kwitansi' => $nomor_kwitansi,
            'penjualan_id' => $request->penjualan_id,
            'tanggal_kwitansi' => $request->tanggal_kwitansi,
            'nama_penerima' => $request->nama_penerima,
            'alamat_penerima' => $request->alamat_penerima,
            'total_bilangan' => ucwords($bilangan),
            'keterangan' => $request->keterangan,
            'total_pembayaran' => $request->total_pembayaran,
            'penandatangan' => $request->penandatangan,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Kwitansi berhasil dibuat dan disimpan.');
    }

    public function print(Kwitansi $kwitansi)
    {
        $kwitansi->load(['penjualan.items.barang', 'user']);
        return view('admin.kwitansi.print', compact('kwitansi'));
    }

    public function destroy(Kwitansi $kwitansi)
    {
        $kwitansi->delete();
        return back()->with('success', 'Kwitansi berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        // Simple logic for bulk delete if implemented
        $request->validate(['ids' => 'required|array']);
        Kwitansi::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true]);
    }

    public function terbilang($angka)
    {
        $angka = abs((float)$angka);
        $baca = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $terbilang = "";

        if ($angka < 12) {
            $terbilang = " " . $baca[(int)$angka];
        } elseif ($angka < 20) {
            $terbilang = $this->terbilang($angka - 10) . " belas";
        } elseif ($angka < 100) {
            $terbilang = $this->terbilang(floor($angka / 10)) . " puluh" . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            $terbilang = " seratus" . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $terbilang = $this->terbilang(floor($angka / 100)) . " ratus" . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $terbilang = " seribu" . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $terbilang = $this->terbilang(floor($angka / 1000)) . " ribu" . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $terbilang = $this->terbilang(floor($angka / 1000000)) . " juta" . $this->terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $terbilang = $this->terbilang(floor($angka / 1000000000)) . " milyar" . $this->terbilang(fmod($angka, 1000000000));
        }

        return rtrim($terbilang);
    }
}
