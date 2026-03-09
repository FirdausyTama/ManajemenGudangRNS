<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController
{
    /**
     * Tampilkan daftar admin
     */
    public function index()
    {
        // Ambil semua user kecuali owner, urutkan berdasarkan status (pending di atas) lalu terbaru
        $admins = User::where('role', 'admin')
                      ->orderByRaw("FIELD(status, 'pending', 'active')")
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
