<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Require authentication via standard web session
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['email' => 'Silakan login terlebih dahulu.']);
        }

        $user = Auth::user();

        // Hanya izinkan owner (we are on a route grouped under `owner` middleware)
        if ($user->role !== 'owner') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Fitur ini hanya untuk Owner.');
        }

        return $next($request);
    }
}
