<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || $user->roles !== 'admin') {
            Auth::logout(); // hapus session

            // arahkan ke login admin filament
            return redirect()->route('filament.admin.auth.login')
                             ->withErrors(['auth' => 'Anda tidak memiliki akses ke halaman admin.']);
        }

        return $next($request);
    }
}
