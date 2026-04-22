<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePhoneFilled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && empty(auth()->user()->phone)) {
            return redirect()->route('profile.edit')
                ->with('error', 'Silakan isi nomor telepon terlebih dahulu sebelum meminjam buku.');
        }

        return $next($request); 
    }
}
