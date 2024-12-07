<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        // if (Auth::check() && Auth::user()->role === 'admin') {
        if (Auth::check() && Auth::user()->name === 'Admin') {
            return $next($request);
        }

        return redirect('/'); // Перенаправление, если пользователь не администратор
    }
}
