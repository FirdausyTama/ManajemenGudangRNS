<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanController
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $period = $request->input('period');
        $date = $request->input('date');

        $query = Penjualan::with(['items.barang', 'user'])->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_transaksi', 'like', "%{$search}%")
                    ->orWhere('nama_customer', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status_pembayaran', $status);
        }

        if ($date) {
            $query->whereDate('tanggal_transaksi', $date);
        }
        elseif ($period) {
            $now = Carbon::now();
            if ($period === 'today') {
                $query->whereDate('tanggal_transaksi', $now->toDateString());
            }
            elseif ($period === 'week') {
                $query->whereBetween('tanggal_transaksi', [$now->startOfWeek()->toDateString(), $now->endOfWeek()->toDateString()]);
            }
            elseif ($period === 'month') {
                $query->whereMonth('tanggal_transaksi', $now->month)
                    ->whereYear('tanggal_transaksi', $now->year);
            }
            elseif ($period === 'year') {
                $query->whereYear('tanggal_transaksi', $now->year);
            }
        }

        $penjualans = $query->paginate(10)->withQueryString();
        $barangs = Barang::all();

        // Calculate Global Statistics for Status Cards
        $statusStats = [
            'lunas' => Penjualan::where('status_pembayaran', 'lunas')->count(),
            'cicilan' => Penjualan::where('status_pembayaran', 'cicilan')->count(),
            'belum_lunas' => Penjualan::where('status_pembayaran', 'belum lunas')->count(),
        ];

        /**
         * Logic for Installment Reminders:
         * 1. Status is 'cicilan'
         * 2. The day of 'tanggal_transaksi' is within current day to +7 days
         * 3. No kwitansi (payment) recorded in the current month
         */
        $today = Carbon::today();
        $sevenDaysLater = $today->copy()->addDays(7);

        $allCicilan = Penjualan::where('status_pembayaran', 'cicilan')
            ->withCount(['kwitansis as cicilan_paid_count' => function ($q) {
            $q->where('keterangan', 'like', '%Cicilan%');
        }])
            ->get();

        $reminders = $allCicilan->filter(function ($p) use ($today, $sevenDaysLater) {
            // Jika tenor belum diatur, kita asumsikan belum ada jadwal
            if (!$p->tenor_bulan)
                return false;

            // Hitung cicilan ke berapa yang harus dibayar berikutnya
            $nextInstallmentNo = $p->cicilan_paid_count + 1;

            // Jika sudah lunas atau melebihi tenor (meski status masih cicilan), jangan ingatkan
            if ($nextInstallmentNo > $p->tenor_bulan)
                return false;

            // Hitung tanggal jatuh tempo berikutnya
            // Transaksi Tgl 10 Jan -> Cicilan 1: 10 Feb, Cicilan 2: 10 Mar, dst.
            $nextDueDate = Carbon::parse($p->tanggal_transaksi)->addMonths($nextInstallmentNo);

            // Masukkan ke pengingat jika jatuh tempo antara hari ini sampai 7 hari ke depan
            $p->next_due_date = $nextDueDate; // Simpan untuk ditampilkan di view
            return $nextDueDate->between($today, $sevenDaysLater);
        })->take(5);

        return view('admin.penjualan.index', compact('penjualans', 'barangs', 'statusStats', 'reminders'));
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

            if ($request->status_pembayaran === 'lunas') {
                $this->autoCreateKwitansiLunas($penjualan);
            }

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil ditambahkan.');

        }
        catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan penjualan: ' . $e->getMessage())->withInput();
        }
    }

    public function updateStatus(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:lunas,belum lunas,cicilan',
        ]);

        if ($request->status_pembayaran === 'lunas' && $penjualan->status_pembayaran !== 'lunas') {
            $this->autoCreateKwitansiLunas($penjualan);
        }

        $penjualan->update([
            'status_pembayaran' => $request->status_pembayaran
        ]);

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function destroy(Penjualan $penjualan)
    {
        DB::beginTransaction();
        try {
            // Restore stok barangs khusus untuk status 'belum lunas'
            if ($penjualan->status_pembayaran === 'belum lunas') {
                foreach ($penjualan->items as $item) {
                    if ($item->barang) {
                        $item->barang->increment('stock', $item->kuantitas);
                    }
                }
            }

            $statusText = $penjualan->status_pembayaran;
            $penjualan->delete(); // automatically cascades deletes to items based on DB migration

            DB::commit();

            $msg = 'Data penjualan berhasil dihapus.';
            if ($statusText === 'belum lunas') {
                $msg .= ' Stok barang telah dikembalikan ke dalam gudang.';
            }
            else {
                $msg .= ' Stok tidak dikembalikan karena status pembelian sudah Cicilan/Lunas.';
            }

            return redirect()->route('penjualan.index')->with('success', $msg);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus penjualan: ' . $e->getMessage());
        }
    }

    public function setTenor(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'tenor_bulan' => 'required|integer|min:1|max:60',
            'dp_nominal' => 'nullable|numeric|min:0'
        ]);

        $penjualan->update([
            'tenor_bulan' => $request->tenor_bulan
        ]);

        // Jika ada DP, catat sebagai kwitansi pertama
        if ($request->filled('dp_nominal') && $request->dp_nominal > 0) {
            $year = date('Y');
            $latest = \App\Models\Kwitansi::whereYear('tanggal_kwitansi', $year)->latest('id')->first();
            $nextId = $latest ? $latest->id + 1 : 1;
            $nomor_kwitansi = 'KWT/' . str_pad($nextId, 3, '0', STR_PAD_LEFT) . '/RNS/' . $year;

            $kwtController = new \App\Http\Controllers\KwitansiController();
            $bilangan = $kwtController->terbilang($request->dp_nominal) . ' Rupiah';

            \App\Models\Kwitansi::create([
                'nomor_kwitansi' => $nomor_kwitansi,
                'penjualan_id' => $penjualan->id,
                'tanggal_kwitansi' => today(),
                'nama_penerima' => $penjualan->nama_customer,
                'alamat_penerima' => $penjualan->alamat_customer,
                'total_bilangan' => ucwords($bilangan),
                'keterangan' => 'Pembayaran Uang Muka (DP)',
                'total_pembayaran' => $request->dp_nominal,
                'penandatangan' => auth()->user()->name ?? 'Dewi Sulistiowati',
                'user_id' => auth()->id(),
            ]);

            $totalDibayar = $penjualan->kwitansis()->sum('total_pembayaran');
            if ($totalDibayar >= $penjualan->total_keseluruhan) {
                $penjualan->update(['status_pembayaran' => 'lunas']);
            }
        }

        return back()->with('success', 'Tenor cicilan berhasil diatur menjadi ' . $request->tenor_bulan . ' bulan.');
    }

    public function storeCicilan(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'total_pembayaran' => 'required|numeric|min:1',
            'tanggal_kwitansi' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Auto-generate kwitansi number
            $lastKwitansi = \App\Models\Kwitansi::latest('id')->first();
            $nextId = $lastKwitansi ? $lastKwitansi->id + 1 : 1;
            $nomorKwitansi = 'KWT-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            // Determine cicilan count
            $cicilanKe = $penjualan->kwitansis()->count() + 1;

            // Format received amount for 'terbilang' (words)
            // We use the same 'terbilang' logic as the main KwitansiController
            $terbilang = app(\App\Http\Controllers\KwitansiController::class)->terbilang($request->total_pembayaran) . ' Rupiah';

            // Create kwitansi specifically for this installment
            $penjualan->kwitansis()->create([
                'nomor_kwitansi' => $nomorKwitansi,
                'tanggal_kwitansi' => $request->tanggal_kwitansi,
                'nama_penerima' => $penjualan->nama_customer,
                'alamat_penerima' => $penjualan->alamat_customer ?? '-',
                'total_bilangan' => $terbilang,
                'total_pembayaran' => $request->total_pembayaran,
                'keterangan' => $request->keterangan ?? "Pembayaran Cicilan ke-{$cicilanKe} untuk Transaksi {$penjualan->no_transaksi}",
                'penandatangan' => auth()->user()->name,
                'user_id' => auth()->id()
            ]);

            // Check if fully paid
            $totalDibayar = $penjualan->kwitansis()->sum('total_pembayaran');
            if ($totalDibayar >= $penjualan->total_keseluruhan) {
                $penjualan->update(['status_pembayaran' => 'lunas']);
                $msg = 'Pembayaran cicilan berhasil dicatat. Transaksi ini sekarang telah LUNAS!';
            }
            else {
                $msg = 'Pembayaran cicilan ke-' . $cicilanKe . ' berhasil dicatat sebagai Kwitansi.';
            }

            DB::commit();
            return back()->with('success', $msg);

        }
        catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan cicilan: ' . $e->getMessage());
        }
    }

    private function autoCreateKwitansiLunas(Penjualan $penjualan)
    {
        $exists = \App\Models\Kwitansi::where('penjualan_id', $penjualan->id)
            ->where('keterangan', 'like', '%Lunas%')
            ->exists();

        if ($exists) {
            return;
        }

        $year = date('Y', strtotime($penjualan->tanggal_transaksi));
        $latest = \App\Models\Kwitansi::whereYear('tanggal_kwitansi', $year)->latest('id')->first();
        $nextId = $latest ? $latest->id + 1 : 1;
        $nomor_kwitansi = 'KWT/' . str_pad($nextId, 3, '0', STR_PAD_LEFT) . '/RNS/' . $year;

        $terbilang = app(\App\Http\Controllers\KwitansiController::class)->terbilang($penjualan->total_keseluruhan) . ' Rupiah';

        \App\Models\Kwitansi::create([
            'nomor_kwitansi' => $nomor_kwitansi,
            'penjualan_id' => $penjualan->id,
            'tanggal_kwitansi' => $penjualan->tanggal_transaksi ?? today(),
            'nama_penerima' => $penjualan->nama_customer,
            'alamat_penerima' => $penjualan->alamat_customer ?? '-',
            'total_bilangan' => ucwords($terbilang),
            'keterangan' => 'Pembayaran Lunas untuk Transaksi ' . $penjualan->no_transaksi,
            'total_pembayaran' => $penjualan->total_keseluruhan,
            'penandatangan' => auth()->user()->name ?? 'Admin',
            'user_id' => auth()->id()
        ]);
    }
}
