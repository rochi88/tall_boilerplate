<?php

declare(strict_types=1);

namespace App\Modules\Security\Http\Middleware;

use App\Support\APIResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

final class IPAuthorizationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        if ($ip === null) {
            return APIResponse::showErrorResponse(
                Response::HTTP_UNAUTHORIZED
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Fast allowlist check (cache → DB)
        |--------------------------------------------------------------------------
        */
        $allowedIps = Cache::remember(
            'security:ip_allowlist:v1',
            now()->addMinutes(5),
            fn (): array => $this->allowedIps()
        );

        if (! in_array($ip, $allowedIps, true)) {
            return APIResponse::showErrorResponse(
                Response::HTTP_UNAUTHORIZED
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Mark request as IP-verified (used by downstream middleware)
        |--------------------------------------------------------------------------
        */
        $request->attributes->set('ip_authorized', true);

        return $next($request);
    }

    /**
     * Fetch allow-listed IPs from security storage.
     *
     * NOTE:
     *  - CIDR support can be added here later
     *  - This is intentionally read-only
     */
    private function allowedIps(): array
    {
        return \DB::table('ip_lists')
            ->where('status', 'whitelist')
            ->whereNull('deleted_at')
            ->pluck('ip_address')
            ->filter()
            ->values()
            ->all();
    }
}
