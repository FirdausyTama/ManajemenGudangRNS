<?php

namespace App\Http\Controllers;

use App\Models\ServiceReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ServiceReportController
{
    public function index(Request $request)
    {
        $period = $request->input('period');
        $date = $request->input('date');
        $search = $request->input('search');

        $query = ServiceReport::with(['user'])->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('report_no', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('equipment_brand', 'like', "%{$search}%");
            });
        }

        if ($date) {
            $query->whereDate('working_start', $date);
        } elseif ($period) {
            $now = Carbon::now();
            if ($period === 'today') {
                $query->whereDate('working_start', $now->toDateString());
            } elseif ($period === 'week') {
                $query->whereBetween('working_start', [$now->startOfWeek()->toDateString(), $now->endOfWeek()->toDateString()]);
            } elseif ($period === 'month') {
                $query->whereMonth('working_start', $now->month)
                      ->whereYear('working_start', $now->year);
            } elseif ($period === 'year') {
                $query->whereYear('working_start', $now->year);
            }
        }

        $service_reports = $query->paginate(10)->withQueryString();

        return view('admin.service-report.index', compact('service_reports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'customer_address' => 'required|string',
            'department' => 'required|string',
            'equipment_brand' => 'required|string',
            'equipment_model' => 'required|string',
            'service_status' => 'nullable|string',
            'problem' => 'required|string',
            'action' => 'required|string',
            'working_start' => 'required|date',
            'working_finish' => 'required|date',
            'working_status' => 'nullable|string',
            'engineer_name' => 'required|string',
        ]);

        $report_no = ServiceReport::generateNumber($request->working_start);

        ServiceReport::create([
            'report_no' => $report_no,
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'department' => $request->department,
            'equipment_brand' => $request->equipment_brand,
            'equipment_model' => $request->equipment_model,
            'service_status' => $request->service_status ?? '-',
            'problem' => $request->problem,
            'action' => $request->action,
            'remark' => $request->remark,
            'recommendation' => $request->recommendation,
            'working_start' => $request->working_start,
            'working_finish' => $request->working_finish,
            'working_status' => $request->working_status ?? '-',
            'engineer_name' => $request->engineer_name,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Service Report berhasil dibuat dan disimpan.');
    }

    public function print(ServiceReport $service_report)
    {
        return view('admin.service-report.print', compact('service_report'));
    }

    public function destroy(ServiceReport $service_report)
    {
        $service_report->delete();
        return back()->with('success', 'Service Report berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        ServiceReport::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true]);
    }
}
