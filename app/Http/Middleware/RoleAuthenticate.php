<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleAuthenticate
{

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guard = $guards[0];
        $user = auth()->user();

        if (!$user || $user->role !== $guard) {
            return back()
                ->with('error', 'You do not have access to this resource');
        }

        return $next($request);
    }
}
