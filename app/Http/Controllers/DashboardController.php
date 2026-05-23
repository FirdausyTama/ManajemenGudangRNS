<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Penjualan;
use App\Models\PenjualanItem;
use App\Models\Kwitansi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController
{
    public function index()
    {
        $now = Carbon::now();
        $thisMonthStart = $now->copy()->startOfMonth();
        $thisMonthEnd = $now->copy()->endOfMonth();

        // 1. Total Stok Keseluruhan
        $totalStok = (int)Barang::sum('stock');

        // 2. Keuntungan dan Pendapatan Per Bulan (berdasarkan item, tidak termasuk ongkir, dan hanya Lunas/Cicilan)
        $monthlyItemsData = PenjualanItem::whereHas('penjualan', function($q) use ($thisMonthStart, $thisMonthEnd) {
                $q->whereBetween('tanggal_transaksi', [$thisMonthStart, $thisMonthEnd])
                  ->whereIn('status_pembayaran', ['lunas', 'cicilan']);
            })
            ->with('barang')
            ->get();

        $monthlyProfit = 0;
        $monthlyRevenue = 0;
        foreach ($monthlyItemsData as $item) {
            $cost = (float)($item->barang->purchase_price ?? 0);
            $sell = (float)$item->harga_satuan;
            $qty = (int)$item->kuantitas;
            
            $monthlyRevenue += ($sell * $qty);
            $monthlyProfit += (($sell - $cost) * $qty);
        }

        // 3. Total Piutang (Grand Total - Total Paid for unpaid/installment transactions)
        $unpaidPenjualans = Penjualan::where('status_pembayaran', '!=', 'lunas')->with('kwitansis')->get();
        $totalReceivable = 0;
        foreach ($unpaidPenjualans as $p) {
            $paid = (float)$p->kwitansis->sum('total_pembayaran');
            $sisa = (float)$p->total_keseluruhan - $paid;
            if ($sisa > 0) {
                $totalReceivable += $sisa;
            }
        }

        // 4. Peringatan Jatuh Tempo (Logic from PenjualanController)
        $today = Carbon::today();
        $sevenDaysLater = $today->copy()->addDays(7);
        $allCicilan = Penjualan::where('status_pembayaran', 'cicilan')
            ->withCount(['kwitansis as cicilan_paid_count' => function($q) {
                $q->where('keterangan', 'like', '%Cicilan%');
            }])
            ->get();

        $reminders = $allCicilan->filter(function($p) use ($today, $sevenDaysLater) {
            if (!$p->tenor_bulan) return false;
            $nextInstallmentNo = $p->cicilan_paid_count + 1;
            if ($nextInstallmentNo > $p->tenor_bulan) return false;
            $nextDueDate = Carbon::parse($p->tanggal_transaksi)->addMonths($nextInstallmentNo);
            $p->next_due_date = $nextDueDate; 
            return $nextDueDate->between($today, $sevenDaysLater);
        })->take(5);

        // 5. 5 Transaksi Terakhir
        $recentTransactions = Penjualan::with(['items.barang'])->latest()->take(5)->get();

        // 6. Total Lunas & Cicilan Count
        $lunasCount = Penjualan::where('status_pembayaran', 'lunas')->count();
        $cicilanCount = Penjualan::where('status_pembayaran', 'cicilan')->count();

        // 7. Grafik Barang Paling Laris
        $topSelling = PenjualanItem::select('barang_id', DB::raw('SUM(kuantitas) as total_qty'))
            ->groupBy('barang_id')
            ->orderByDesc('total_qty')
            ->with('barang')
            ->take(5)
            ->get();

        $chartData = [
            'labels' => $topSelling->map(fn($t) => $t->barang->name ?? 'N/A'),
            'values' => $topSelling->map(fn($t) => (int)$t->total_qty),
        ];

        // 8. Low Stock Count
        $lowStockCount = Barang::where('stock', '>', 0)->where('stock', '<', 10)->count();

        // 9. Total Asset Value
        $totalAssetValue = (float)Barang::select(DB::raw('SUM(stock * purchase_price) as total'))->first()->total;

        // 10. Total Revenue Month
        // (Sudah dihitung di atas bersamaan dengan Profit)

        // 11. Recent Stock In
        $recentStockIn = BarangMasuk::with('barang')->latest()->take(5)->get();

        return view('dashbor.dashboard', compact(
            'totalStok', 
            'monthlyProfit', 
            'totalReceivable', 
            'reminders', 
            'recentTransactions', 
            'chartData',
            'lunasCount',
            'cicilanCount',
            'lowStockCount',
            'totalAssetValue',
            'monthlyRevenue',
            'recentStockIn'
        ));
    }
}
