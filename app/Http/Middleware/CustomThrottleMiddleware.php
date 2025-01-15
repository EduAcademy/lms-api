<?php

namespace App\Http\Middleware;

use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Closure;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpFoundation\Response;

class CustomThrottleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, $maxAttempts = 3, $decayMinutes = 1)
    {
        // Generate a unique key for rate limiting (IP address or user identifier)
        $key = $this->resolveKey($request);

        // Define the rate limit rule
        RateLimiter::for($key, function () use ($maxAttempts, $decayMinutes) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinutes($decayMinutes, $maxAttempts);
        });

        // Check if the limit has been exceeded
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $retryAfter = RateLimiter::availableIn($key);
            return Result::error('Too many requests', StatusResponse::HTTP_TOO_MANY_REQUESTS);
            // throw new ThrottleRequestsException('', null, $retryAfter);
        }

        // Increment the request count
        RateLimiter::hit($key, $decayMinutes * 60);

        return $next($request);
    }

    /**
     * Resolve the unique key for rate limiting.
     */
    protected function resolveKey($request)
    {
        return $request->user()?->id ?: $request->ip();
    }
}
