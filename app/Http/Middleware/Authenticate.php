<?php

namespace App\Http\Middleware;

use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming unauthenticated request.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        abort(Result::error('Token is expired or invalid', StatusResponse::HTTP_UNAUTHORIZED));
    }
}
