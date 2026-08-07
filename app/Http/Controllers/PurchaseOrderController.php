<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PurchaseOrderController
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $date = $request->input('date');
        $period = $request->input('period');

        $query = PurchaseOrder::with(['items', 'user'])->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_po', 'like', "%{$search}%")
                    ->orWhere('supplier_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_po', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('month')) {
            $monthParts = explode('-', $request->month);
            if (count($monthParts) == 2) {
                $query->whereYear('tanggal_po', $monthParts[0])
                      ->whereMonth('tanggal_po', $monthParts[1]);
            }
        }

        $purchaseOrders = $query->paginate(10)->withQueryString();

        return view('admin.purchase-order.index', compact('purchaseOrders'));
    }

    public function store(Request $request)
    {
        // Strip dots from harga_satuan to allow thousands separator formatting
        if ($request->has('items') && is_array($request->items)) {
            $items = $request->items;
            foreach ($items as &$item) {
                if (isset($item['harga_satuan'])) {
                    $item['harga_satuan'] = str_replace('.', '', $item['harga_satuan']);
                }
            }
            $request->merge(['items' => $items]);
        }

        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'tanggal_po' => 'required|date',
            'pembayaran' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'penandatangan' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.deskripsi' => 'required|string|max:255',
            'items.*.satuan' => 'required|string|max:255',
            'items.*.kuantitas' => 'required|numeric|min:0.01',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $po = PurchaseOrder::create([
                'no_po' => PurchaseOrder::generateNoPo($request->tanggal_po),
                'supplier_name' => $request->supplier_name,
                'supplier_address' => $request->supplier_address,
                'tanggal_po' => $request->tanggal_po,
                'pembayaran' => $request->pembayaran,
                'catatan' => $request->catatan,
                'penandatangan' => $request->penandatangan,
                'total_harga' => 0,
                'user_id' => Auth::id(),
            ]);

            $totalHarga = 0;

            foreach ($request->items as $item) {
                $subtotal = $item['kuantitas'] * $item['harga_satuan'];
                $totalHarga += $subtotal;

                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'deskripsi' => $item['deskripsi'],
                    'satuan' => $item['satuan'],
                    'kuantitas' => $item['kuantitas'],
                    'harga_satuan' => $item['harga_satuan'],
                    'total_harga' => $subtotal,
                ]);
            }

            $po->update(['total_harga' => $totalHarga]);

            DB::commit();

            return redirect()->route('purchase-order.index')->with('success', 'Purchase Order berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function print(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('items');
        return view('admin.purchase-order.print', compact('purchaseOrder'));
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        try {
            $purchaseOrder->delete();
            return redirect()->route('purchase-order.index')->with('success', 'Purchase Order berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('purchase-order.index')->with('error', 'Gagal menghapus Purchase Order.');
        }
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:purchase_orders,id'
        ]);

        try {
            PurchaseOrder::whereIn('id', $request->ids)->delete();
            return response()->json([
                'success' => true,
                'message' => count($request->ids) . ' data PO berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
