<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Gelen isteği işle.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Kullanıcı giriş yapmış mı?
        // 2. Kullanıcının 'is_admin' sütunu true (veya 1) mi?
        if (Auth::check() && Auth::user()->is_admin) {
            // Evet, admin. İsteğin devam etmesine izin ver.
            return $next($request);
        }

        // DEĞİŞİKLİK:
        // Hayır, admin değil.
        // Kullanıcıyı 'dashboard' (silinen rota) yerine 'admin.dashboard' (yeni anasayfa) rotasına yönlendir.
        return redirect()->route('admin.dashboard')->with('error', 'Bu alana erişim yetkiniz yok.');
    }
}