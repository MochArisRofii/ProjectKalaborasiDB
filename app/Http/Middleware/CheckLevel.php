<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Mendefinisikan roles yang diizinkan, yaitu 'admin' dan 'kasir'
        $roles = ['admin', 'kasir'];

        // Mengecek apakah pengguna sudah login dan peran pengguna termasuk dalam peran yang diizinkan
        if (auth()->check() && in_array(auth()->user()->role, $roles)) {
            // Jika ya, lanjutkan permintaan ke middleware berikutnya
            return $next($request);
        }

        // Jika role tidak ditemukan atau pengguna tidak memiliki role yang sesuai, redirect ke halaman utama ('/')
        return redirect('/');
    }

}
