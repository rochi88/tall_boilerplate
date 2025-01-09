<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Enums\Messages;
use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

final class JWTTokenMiddleware
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return $this->JWTCustomResponse(Messages::INVALID_USER);
            }
        } catch (JWTException $e) {
            return $this->JWTCustomResponse($e->getMessage());
        }

        return $next($request);
    }
}
