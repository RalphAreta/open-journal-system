<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            // If no active role, set it to user's primary role
            if (!$request->session()->has('active_role')) {
                $primaryRole = $request->user()->primaryRole();
                if ($primaryRole) {
                    $request->session()->put('active_role', $primaryRole->name);
                }
            }
        }

        return $next($request);
    }
}
