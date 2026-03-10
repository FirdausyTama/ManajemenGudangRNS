<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter', 'Semua Waktu');

        $query = Invoice::with(['penjualan', 'user'])->latest();

        if ($search) {
            $query->where('no_invoice', 'like', "%{$search}%")
                  ->orWhereHas('penjualan', function ($q) use ($search) {
                      $q->where('nama_customer', 'like', "%{$search}%");
                  });
        }

        if ($filter == 'Hari Ini') {
            $query->whereDate('tanggal_invoice', today());
        } elseif ($filter == 'Minggu Ini') {
            $query->whereBetween('tanggal_invoice', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter == 'Bulan Ini') {
            $query->whereMonth('tanggal_invoice', now()->month)
                  ->whereYear('tanggal_invoice', now()->year);
        }

        $invoices = $query->paginate(10);
        $penjualans = Penjualan::latest()->get(); // For the dropdown when creating a new invoice manually if needed

        return view('admin.invoice.index', compact('invoices', 'penjualans', 'filter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|exists:penjualans,id',
            'tanggal_invoice' => 'required|date',
            'penandatangan' => 'required|string',
        ]);

        $penjualan = Penjualan::findOrFail($request->penjualan_id);
        
        // Generate Invoice Number
        $year = date('Y', strtotime($request->tanggal_invoice));
        $latestInvoice = Invoice::whereYear('tanggal_invoice', $year)->latest('id')->first();
        $nextId = $latestInvoice ? $latestInvoice->id + 1 : 1;
        $no_invoice = 'INV/' . str_pad($nextId, 3, '0', STR_PAD_LEFT) . '/RNS/' . $year;

        $invoice = Invoice::create([
            'no_invoice' => $no_invoice,
            'penjualan_id' => $penjualan->id,
            'tanggal_invoice' => $request->tanggal_invoice,
            'penandatangan' => $request->penandatangan,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Invoice berhasil dibuat dan disimpan.');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['penjualan.items.barang', 'user']);
        $penjualan = $invoice->penjualan;
        $penandatangan = $invoice->penandatangan;
        $no_invoice = $invoice->no_invoice;
        $tanggal_invoice = $invoice->tanggal_invoice;

        return view('admin.penjualan.print-invoice', compact('penjualan', 'penandatangan', 'no_invoice', 'tanggal_invoice'));
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return back()->with('success', 'Invoice berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:invoices,id',
        ]);

        Invoice::whereIn('id', $request->ids)->delete();
        
        return response()->json(['success' => true, 'message' => 'Invoice terpilih berhasil dihapus.']);
    }
}
