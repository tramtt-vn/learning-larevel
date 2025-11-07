<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     * Kiểm tra đã đăng nhập (auth()->check())
     * Kiểm tra role = admin
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập');
        }

        // Kiểm tra có phải admin không
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Bạn không có quyền truy cập trang này');
        }

        return $next($request);
    }
}
