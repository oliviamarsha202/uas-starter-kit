<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- INI BARIS YANG DITAMBAHKAN

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Sekarang PHP tahu 'Auth' itu merujuk ke class yang benar
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            abort(403, 'ANDA TIDAK PUNYA AKSES.');
        }

        return $next($request);
    }
}