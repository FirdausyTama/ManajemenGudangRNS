<?php

namespace App\Http\Controllers;

use App\Models\SuratPenawaran;
use App\Models\SuratPenawaranItem;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SuratPenawaranController
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $date = $request->input('date');
        $period = $request->input('period');

        $query = SuratPenawaran::with(['user'])->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_sph', 'like', "%{$search}%")
                    ->orWhere('nama_customer', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        if ($date) {
            $query->whereDate('tanggal_sph', $date);
        } elseif ($period) {
            $now = Carbon::now();
            if ($period === 'today') {
                $query->whereDate('tanggal_sph', $now->toDateString());
            } elseif ($period === 'week') {
                $query->whereBetween('tanggal_sph', [$now->startOfWeek()->toDateString(), $now->endOfWeek()->toDateString()]);
            } elseif ($period === 'month') {
                $query->whereMonth('tanggal_sph', $now->month)
                    ->whereYear('tanggal_sph', $now->year);
            } elseif ($period === 'year') {
                $query->whereYear('tanggal_sph', $now->year);
            }
        }

        $surats = $query->paginate(10)->withQueryString();
        $barangs = Barang::orderBy('name')->get();

        return view('admin.surat-penawaran.index', compact('surats', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required|string',
            'jabatan_customer' => 'nullable|string',
            'alamat_customer' => 'nullable|string',
            'no_hp_customer' => 'nullable|string',
            'tanggal_sph' => 'required|date',
            'perihal' => 'required|string',
            'salam_pembuka' => 'nullable|string',
            'deskripsi_tambahan' => 'nullable|string',
            'salam_penutup' => 'nullable|string',
            'syarat_ketentuan' => 'nullable|string',
            'keterangan_pembayaran' => 'nullable|string',
            'penandatangan' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.nama_barang' => 'required|string',
            'items.*.spesifikasi' => 'nullable|string',
            'items.*.kuantitas' => 'required|numeric|min:0.01',
            'items.*.satuan' => 'required|string',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Generate No SPH: XX/SPH/RNS/[Month-In-Roman]/[Year]
            $year = date('Y', strtotime($request->tanggal_sph));
            $month = date('n', strtotime($request->tanggal_sph));
            $romanMonths = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
            
            $count = SuratPenawaran::whereYear('tanggal_sph', $year)->count() + 1;
            $no_sph = str_pad($count, 3, '0', STR_PAD_LEFT) . '/SPH/XRAY/RNS/' . $romanMonths[$month] . '/' . $year;

            $surat = SuratPenawaran::create([
                'no_sph' => $no_sph,
                'nama_customer' => $request->nama_customer,
                'jabatan_customer' => $request->jabatan_customer,
                'alamat_customer' => $request->alamat_customer,
                'no_hp_customer' => $request->no_hp_customer,
                'tanggal_sph' => $request->tanggal_sph,
                'perihal' => $request->perihal,
                'salam_pembuka' => $request->salam_pembuka,
                'salam_penutup' => $request->salam_penutup,
                'syarat_ketentuan' => $request->syarat_ketentuan,
                'keterangan_pembayaran' => $request->keterangan_pembayaran,
                'penandatangan' => $request->penandatangan,
                'total_harga' => 0,
                'user_id' => Auth::id(),
            ]);

            $total_harga = 0;
            foreach ($request->items as $index => $itemData) {
                $subtotal = $itemData['kuantitas'] * $itemData['harga_satuan'];
                $total_harga += $subtotal;

                $itemImages = [];
                if ($request->hasFile("items.$index.images")) {
                    foreach ($request->file("items.$index.images") as $image) {
                        $path = $image->store('surat-penawaran-items', 'public');
                        $itemImages[] = $path;
                    }
                }

                SuratPenawaranItem::create([
                    'surat_penawaran_id' => $surat->id,
                    'barang_id' => $itemData['barang_id'] ?? null,
                    'nama_barang' => $itemData['nama_barang'],
                    'spesifikasi' => $itemData['spesifikasi'],
                    'kuantitas' => $itemData['kuantitas'],
                    'satuan' => $itemData['satuan'],
                    'harga_satuan' => $itemData['harga_satuan'],
                    'total_harga' => $subtotal,
                    'images' => $itemImages,
                ]);
            }

            $surat->update(['total_harga' => $total_harga]);

            DB::commit();
            return back()->with('success', 'Surat Penawaran berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan Surat Penawaran: ' . $e->getMessage());
        }
    }

    public function destroy(SuratPenawaran $surat_penawaran)
    {
        $surat_penawaran->delete();
        return back()->with('success', 'Surat Penawaran berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:surat_penawarans,id',
        ]);

        SuratPenawaran::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true, 'message' => 'Surat Penawaran terpilih berhasil dihapus.']);
    }

    public function print(SuratPenawaran $surat_penawaran)
    {
        $surat_penawaran->load(['items.barang.barangMasuks', 'user']);
        return view('admin.surat-penawaran.print', compact('surat_penawaran'));
    }

    public function editData(SuratPenawaran $surat_penawaran)
    {
        return response()->json($surat_penawaran->load('items'));
    }

    public function terbilang($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = $this->terbilang($nilai - 10). " Belas";
        } else if ($nilai < 100) {
            $temp = $this->terbilang($nilai/10)." Puluh". $this->terbilang($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . $this->terbilang($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->terbilang($nilai/100) . " Ratus" . $this->terbilang($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . $this->terbilang($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->terbilang($nilai/1000) . " Ribu" . $this->terbilang($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->terbilang($nilai/1000000) . " Juta" . $this->terbilang($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->terbilang($nilai/1000000000) . " Milyar" . $this->terbilang(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->terbilang($nilai/1000000000000) . " Trilyun" . $this->terbilang(fmod($nilai,1000000000000));
        }     
        return $temp;
    }
}
