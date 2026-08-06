<?php

namespace App\Http\Controllers;

use App\Models\SuratSerahTerima;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratSerahTerimaController
{
    public function index(Request $request)
    {
        $query = SuratSerahTerima::with('user');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('kepada', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%");
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('month')) {
            $monthParts = explode('-', $request->month);
            if (count($monthParts) == 2) {
                $query->whereYear('tanggal', $monthParts[0])
                      ->whereMonth('tanggal', $monthParts[1]);
            }
        }

        if ($request->has('date') && $request->date != '') {
            $query->whereDate('tanggal', $request->date);
        }

        $surat_serah_terimas = $query->latest()->paginate(10)->withQueryString();
        $penjualans = Penjualan::with('items.barang')->latest()->get(); // For dropdown in modal

        return view('admin.serah-terima.index', compact('surat_serah_terimas', 'penjualans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kepada' => 'required|string|max:255',
            'alamat' => 'required|string',
            'pengirim' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.nama_barang' => 'required|string|max:255',
            'items.*.qty' => 'required|string|max:50',
            'items.*.jumlah' => 'required|string|max:50',
        ]);

        // Generate nomor surat
        $year = date('Y', strtotime($request->tanggal));
        $month = date('n', strtotime($request->tanggal));
        $romanMonths = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

        $count = SuratSerahTerima::whereYear('tanggal', $year)
                            ->whereMonth('tanggal', $month)
                            ->count() + 1;
        $nomor_surat = str_pad($count, 2, '0', STR_PAD_LEFT) . '/STB/RNS-' . $romanMonths[$month] . '/' . $year;

        SuratSerahTerima::create([
            'nomor_surat' => $nomor_surat,
            'tanggal' => $request->tanggal,
            'kepada' => $request->kepada,
            'alamat' => $request->alamat,
            'keterangan' => $request->keterangan,
            'items' => json_encode($request->items),
            'pengirim' => $request->pengirim,
            'penjualan_id' => $request->penjualan_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('serah-terima.index')->with('success', 'Surat Serah Terima berhasil dibuat.');
    }

    public function destroy($id)
    {
        $sst = SuratSerahTerima::findOrFail($id);
        $sst->delete();
        return redirect()->route('serah-terima.index')->with('success', 'Surat Serah Terima berhasil dihapus.');
    }

    public function print($id)
    {
        $surat = SuratSerahTerima::findOrFail($id);
        return view('admin.serah-terima.print', compact('surat'));
    }
}
