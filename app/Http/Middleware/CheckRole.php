<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = strtolower(Auth::user()->role);
        $targetRole = strtolower($role);

        // Menyamakan 'pengguna' dengan 'user'
        $isUser = in_array($userRole, ['user', 'pengguna']);
        $isTargetUser = in_array($targetRole, ['user', 'pengguna']);

        // Jika akses sesuai role (Admin -> Admin, atau User/Pengguna -> User)
        if (($userRole === 'admin' && $targetRole === 'admin') || ($isUser && $isTargetUser)) {
            return $next($request);
        }

        // Jika Admin mencoba akses route user -> lempar ke dashboard admin
        if ($userRole === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Jika Pengguna / User mencoba akses route admin -> lempar ke dashboard user
        if ($isUser) {
            return redirect()->route('user.dashboard');
        }

        abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang.');
    }
}
