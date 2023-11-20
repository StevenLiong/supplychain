<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRoleById
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $roleId)
    {
        if (!Auth::check()) {
            // Pengguna belum login, arahkan ke halaman login
            return redirect('/login');
        }

        $user = Auth::user();

        // Periksa apakah pengguna memiliki ID peran yang diizinkan
        if ($user->role_id == $roleId) {
            return $next($request);
        }

        // Pengguna tidak memiliki ID peran yang diizinkan, arahkan ke halaman tidak diizinkan
        return abort(403, 'Unauthorized');
    }
}
