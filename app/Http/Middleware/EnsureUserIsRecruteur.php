<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsRecruteur
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isRecruteur()) {
            return redirect('/')->with('error', 'Accès réservé aux recruteurs.');
        }

        return $next($request);
    }
}