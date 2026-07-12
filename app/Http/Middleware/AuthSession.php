<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthSession
{
    public function handle(Request $request, Closure $next): Response
    {
        // cek session login
        if (!session()->has('id_user')) {
            return redirect('/login');
        }

        return $next($request);
    }
}