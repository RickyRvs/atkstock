<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Cara pakai di routes:
     *   Route::middleware('role:admin')->group(function () { ... });
     *   Route::middleware('role:admin,petugas')->group(function () { ... });
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // User harus login dulu
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Cek apakah role user ada di daftar role yang diizinkan
        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }

        // Cek apakah akun masih aktif
        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda telah dinonaktifkan. Hubungi administrator.');
        }

        return $next($request);
    }
}
