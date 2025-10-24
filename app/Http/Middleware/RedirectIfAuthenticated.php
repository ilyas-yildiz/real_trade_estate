<?php

namespace App\Http\Middleware;

// DİKKAT: RouteServiceProvider'ı sildim çünkü Breeze'in varsayılan
// kurulumunda HOME sabiti artık burada kullanılmıyor.
// Eğer sende bu dosya varsa (eski projeden) ve hata alırsan
// 'use App\Providers\RouteServiceProvider;' satırını geri ekleyebiliriz.
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // DEĞİŞİKLİK: Yönlendirme hedefi 'admin.dashboard' rotası olarak güncellendi.
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}