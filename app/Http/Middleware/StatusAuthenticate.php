<?php

namespace App\Http\Middleware;

use App\Enums\StatusCode;
use App\Traits\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusAuthenticate
{
    use HttpResponses;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guard = $guards[0];
        $user = auth()->user();

        if (!$user || $user->status !== $guard) {
            return $this->failed(null, StatusCode::Forbidden->value, 'You do not have access to this resource');
        }
        return $next($request);
    }
}
