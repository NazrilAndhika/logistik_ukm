<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Jika role user tidak sama dengan role yang diminta (admin), tendang balik ke katalog
        if (Auth::user()->role !== $role) {
            return redirect('/dashboard'); 
        }

        return $next($request);
    }
}