<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // Cek apakah pengguna sudah login menggunakan Auth::check()
        if (Auth::check()) {
            // Jika sudah login, arahkan berdasarkan role pengguna
            return $this->redirectkasus(Auth::user()->role); // Panggil fungsi redirectkasus untuk mengarahkan berdasarkan role
        }

        // Jika pengguna belum login, lanjutkan permintaan ke middleware berikutnya
        return $next($request);
    }

    // Fungsi untuk mengarahkan pengguna berdasarkan role
    private function redirectkasus($role)
    {
        // Berdasarkan role, arahkan ke halaman yang sesuai
        switch ($role) {
            case 'admin': // Jika role 'admin', arahkan ke /admin
                return redirect('/admin');
            case 'kasir': // Jika role 'kasir', arahkan ke /kasir
                return redirect('/kasir');
            default:
                // Bisa menambahkan penanganan untuk role lain atau default jika diperlukan
                return redirect('/'); // Jika role tidak dikenal, arahkan ke halaman utama
        }
    }

}
