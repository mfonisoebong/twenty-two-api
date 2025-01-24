<?php

namespace App\Http\Middleware;

use App\Enums\StatusCode;
use App\Traits\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Verified
{

    use HttpResponses;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->email_verified_at) {
            return $this->failed(null, StatusCode::Forbidden->value, 'Verify your account');
        }

        return $next($request);
    }
}
