<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BayiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // YENİ: Sadece Bayi (role=1) olanların geçişine izin ver
        if (Auth::check() && Auth::user()->isBayi()) {
            return $next($request);
        }
        
        // Admin veya Müşteri ise dashboard'a yönlendir
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isCustomer())) {
             return redirect()->route('admin.dashboard');
        }

        return redirect('/');
    }
}