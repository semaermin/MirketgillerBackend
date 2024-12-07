<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Kullanıcının giriş yapıp yapmadığını kontrol edin
        if (!Auth::check() || Auth::user()->role !== $role) {
            return redirect('/'); // İzin verilmeyen kullanıcıları ana sayfaya yönlendirin
        }

        return $next($request);
    }
}
