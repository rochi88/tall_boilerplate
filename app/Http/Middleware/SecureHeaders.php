<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Adds security-related HTTP response headers to every request.
 *
 * References:
 *  - https://owasp.org/www-project-secure-headers/
 *  - https://securityheaders.com
 */
final class SecureHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Prevent MIME-type sniffing — always honour the declared Content-Type.
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Disallow embedding in frames from other origins (clickjacking protection).
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Disable the browser's legacy XSS auditor (modern browsers ignore it; old
        // ones can be exploited through it — setting to 0 is the safe choice).
        $response->headers->set('X-XSS-Protection', '0');

        // Control how much referrer information is included with requests.
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Restrict access to browser features not needed by this application.
        $response->headers->set(
            'Permissions-Policy',
            'accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()',
        );

        // Remove the X-Powered-By header that reveals the PHP version.
        $response->headers->remove('X-Powered-By');

        // HSTS: instruct browsers to always use HTTPS for this domain.
        // Only sent over a secure connection to avoid locking out HTTP-only environments.
        if ($request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload',
            );
        }

        return $response;
    }
}
