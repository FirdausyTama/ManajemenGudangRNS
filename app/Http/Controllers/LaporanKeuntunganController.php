<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanKeuntunganController
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'day'); // day, week, month, year
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $barangId = $request->get('barang_id');

        $barangs = \App\Models\Barang::all();

        $query = PenjualanItem::with(['barang', 'penjualan'])
            ->whereHas('penjualan', function ($q) {
            $q->whereIn('status_pembayaran', ['lunas', 'cicilan']);
        });

        if ($barangId) {
            $query->where('barang_id', $barangId);
        }

        // Apply filters based on request
        if ($startDate && $endDate) {
            $query->whereHas('penjualan', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
            });
        }
        else {
            // Default filters if no custom range provided
            $query->whereHas('penjualan', function ($q) use ($filter) {
                if ($filter == 'day') {
                    $q->whereDate('tanggal_transaksi', Carbon::today());
                }
                elseif ($filter == 'week') {
                    $q->whereBetween('tanggal_transaksi', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                }
                elseif ($filter == 'month') {
                    $q->whereMonth('tanggal_transaksi', Carbon::now()->month)
                        ->whereYear('tanggal_transaksi', Carbon::now()->year);
                }
                elseif ($filter == 'year') {
                    $q->whereYear('tanggal_transaksi', Carbon::now()->year);
                }
            });
        }

        $items = $query->get();

        $summary = [
            'total_items_sold' => 0,
            'total_modal' => 0,
            'total_pendapatan' => 0,
            'total_keuntungan' => 0,
        ];

        $reportData = $items->map(function ($item) use (&$summary) {
            $purchasePrice = $item->barang->purchase_price ?? 0;
            $sellingPrice = $item->harga_satuan; // Use actual selling price from transaction
            $qty = $item->kuantitas;

            $modalTotal = $purchasePrice * $qty;
            $pendapatanTotal = $sellingPrice * $qty;
            $keuntunganTotal = $pendapatanTotal - $modalTotal;

            $summary['total_items_sold'] += $qty;
            $summary['total_modal'] += $modalTotal;
            $summary['total_pendapatan'] += $pendapatanTotal;
            $summary['total_keuntungan'] += $keuntunganTotal;

            return [
            'tanggal' => $item->penjualan->tanggal_transaksi->format('Y-m-d'),
            'no_transaksi' => $item->penjualan->no_transaksi,
            'nama_customer' => $item->penjualan->nama_customer,
            'barang' => $item->barang->name ?? 'N/A',
            'qty' => $qty,
            'harga_beli' => $purchasePrice,
            'harga_jual' => $sellingPrice,
            'modal_total' => $modalTotal,
            'pendapatan_total' => $pendapatanTotal,
            'keuntungan_total' => $keuntunganTotal,
            ];
        });

        // Optional: Grouping for display if filter is selected
        // We can pass the raw reportData and let the view handle specific display items

        return view('admin.laporan-keuntungan.index', compact('reportData', 'summary', 'filter', 'startDate', 'endDate', 'barangs', 'barangId'));
    }
}
