<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController
{
    /**
     * Tampilkan daftar admin
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = User::where('role', 'admin');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status === 'pending') {
            $query->where('status', 'pending');
        }
        elseif ($status === 'active') {
            // Aktif = Online (terlihat dalam 5 menit terakhir) dan statusnya bukan pending
            $query->where('status', 'active')
                ->where('last_seen_at', '>=', now()->subMinutes(5));
        }
        elseif ($status === 'inactive') {
            // Tidak Aktif = statusnya bukan pending (jadi active) tapi sudah offline atau belum pernah login
            $query->where('status', 'active')
                ->where(function ($q) {
                $q->whereNull('last_seen_at')
                    ->orWhere('last_seen_at', '<', now()->subMinutes(5));
            });
        }

        // Ambil semua user kecuali owner, urutkan berdasarkan status (pending di atas) lalu terbaru
        $admins = $query->orderByRaw("FIELD(status, 'pending', 'active')")
            ->latest()
            ->get();

        return view('admin.manage', compact('admins'));
    }

    /**
     * Terima/Approve Admin
     */
    public function approve($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->role === 'admin' && $admin->status === 'pending') {
            $admin->update(['status' => 'active']);
            return back()->with('success', "Admin {$admin->name} berhasil disetujui.");
        }

        return back()->with('error', 'Gagal menyetujui admin.');
    }

    /**
     * Tolak/Hapus Admin
     */
    public function reject($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->role === 'admin') {
            $name = $admin->name;
            $admin->delete();
            return back()->with('success', "Akun admin {$name} berhasil dihapus/ditolak.");
        }

        return back()->with('error', 'Gagal menghapus admin.');
    }
}
