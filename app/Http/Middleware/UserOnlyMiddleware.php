<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserOnlyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // kalau belum login, biar middleware 'auth' yang tangani
        if (! $user) {
            return $next($request);
        }

        // kalau admin, jangan boleh pakai route user -> lempar ke dashboard admin
        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.dashboard');
                // ->with('error', 'Admin tidak bisa mengakses halaman pengguna.');
        }

        // role lain (user biasa) lanjut
        return $next($request);
    }
}
