<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap');
        }

        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập!');
        }

        return $next($request);
    }
}
