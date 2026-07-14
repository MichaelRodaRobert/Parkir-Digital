<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = strtolower(trim(Auth::user()->role));
        $targetRole = strtolower(trim($role));

        // Jika role sesuai, izinkan lewat
        if ($userRole === $targetRole) {
            return $next($request);
        }

        // Jika tidak sesuai, alihkan ke tempat yang benar sesuai rolenya
        if ($userRole === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }
}
