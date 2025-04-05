<?php

namespace App\Http\Middleware;

use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user || !in_array($user->role->name, $roles)) {
            return Result::error('Forbidden', StatusResponse::HTTP_FORBIDDEN); // Forbidden
        }

        return $next($request);
    }
}
