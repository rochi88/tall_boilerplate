<?php

declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Enums\{ApiStatus, Messages};
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class IPAuthorizationMiddleware
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // TODO: Allowed Ips will be fetch from database and cache the result
        $allowedIPs = ['127.0.0.1', '192.168.0.102', 'localhost'];

        if (!in_array($request->ip(), $allowedIPs)) {
            return response([
                'response' => [
                    'status'      => ApiStatus::ERROR,
                    'status_code' => Response::HTTP_UNAUTHORIZED,
                    'error'       => [
                        'message'   => Messages::UNAUTHORIZED_DOMAIN_OR_IP,
                        'timestamp' => Carbon::now(),
                    ],
                ],
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
