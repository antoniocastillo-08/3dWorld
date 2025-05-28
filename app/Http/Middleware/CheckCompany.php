<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCompany
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Verificar si el usuario tiene una empresa asociada
        if (!$user || !$user->workstation_id) {
            return redirect()->route('company.options')->with('error', 'You must belong to a company to access this section.');
        }

        return $next($request);
    }
}