<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController
{
    /**
     * Register
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.unique' => 'Email sudah terpakai, silakan gunakan email lain.',
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'name.required' => 'Nama wajib diisi.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'admin',
            'status'   => 'pending',
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Tunggu persetujuan dari owner.');
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->status !== 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'email' => 'Akun belum disetujui oleh owner.',
                ])->onlyInput('email');
            }

            // Record login time
            Auth::user()->update([
                'last_login_at' => now(),
                'last_seen_at' => now(),
            ]);

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->update(['last_seen_at' => null]);
        }
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * List semua user (owner only)
     */
    public function listAllUsers(Request $request)
    {
        $user = $request->user();

        if (!$user || $user->role !== 'owner') {
            return response()->json(['message' => 'Akses ditolak. Hanya owner yang bisa melihat daftar user.'], 403);
        }

        $users = User::all();

        return response()->json([
            'message' => 'Daftar semua user berhasil diambil.',
            'data' => $users
        ]);
    }

    /**
     * Setujui admin (owner only)
     */
    public function approveAdmin(Request $request, $id)
    {
        $owner = $request->user();

        if (!$owner || $owner->role !== 'owner') {
            return response()->json(['message' => 'Akses ditolak. Hanya owner yang bisa menyetujui admin.'], 403);
        }

        $admin = User::findOrFail($id);

        if ($admin->role !== 'admin') {
            return response()->json(['message' => 'User bukan admin.'], 400);
        }

        $admin->status = 'active';
        $admin->save();

        return response()->json([
            'message' => "Admin {$admin->name} telah disetujui.",
            'data' => $admin
        ]);
    }

    /**
     * Tolak admin (owner only)
     */
    public function rejectAdmin(Request $request, $id)
    {
        $owner = $request->user();

        if (!$owner || $owner->role !== 'owner') {
            return response()->json(['message' => 'Akses ditolak. Hanya owner yang bisa menolak admin.'], 403);
        }

        $admin = User::findOrFail($id);

        if ($admin->role !== 'admin') {
            return response()->json(['message' => 'User bukan admin.'], 400);
        }

        $adminName = $admin->name;
        $admin->delete();

        return response()->json(['message' => "Admin {$adminName} telah ditolak dan dihapus."]);
    }
}
