<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!session()->has('id_user')) {
            return redirect('/login');
        }

        if (session('role') !== $role) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}