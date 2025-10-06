<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        $userRole = Auth::user()->role;

        // Cek apakah role user ada di daftar role yang diizinkan
        if (! in_array($userRole, $roles)) {
            abort(403, 'APA YANG KAU CARI?');
        }

        return $next($request);
    }
}
