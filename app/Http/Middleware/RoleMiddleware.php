<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * RoleMiddleware — pembatas akses berbasis peran pengguna.
 * Penggunaan: middleware('role:admin') atau middleware('role:admin,petugas')
 */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$peranDiizinkan): Response
    {
        if (!$request->user()) {
            return redirect()->route('masuk');
        }

        if (!in_array($request->user()->peran, $peranDiizinkan)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}
