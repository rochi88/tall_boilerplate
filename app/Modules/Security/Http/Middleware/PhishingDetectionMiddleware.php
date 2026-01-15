<?php

declare(strict_types=1);

namespace App\Modules\Security\Http\Middleware;

use App\Modules\Security\Events\RiskEvaluated;
use App\Modules\Security\Events\RiskFlagRaised;
use App\Support\Security\RiskEngineInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class PhishingDetectionMiddleware
{
    public function __construct(
        private RiskEngineInterface $riskEngine,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $signals = [
            'ip_reputation'  => $request->attributes->get('ip_reputation'),
            'is_new_device'  => (bool) $request->attributes->get('is_new_device', false),
            'geo_mismatch'   => (bool) $request->attributes->get('geo_mismatch', false),
            'failed_attempts'=> (int) $request->attributes->get('failed_attempts', 0),
        ];

        $result = $this->riskEngine->evaluate($signals);

        /* -------------------------------
         | Emit evaluation event
         |-------------------------------*/
        event(new RiskEvaluated(
            userId: optional($request->user())->id,
            ip: (string) $request->ip(),
            score: $result->score,
            flags: $result->flags,
            signals: $signals,
        ));

        /* -------------------------------
         | Enforcement (sync)
         |-------------------------------*/
        if ($result->block) {
            event(new RiskFlagRaised(
                userId: optional($request->user())->id,
                flagType: 'phishing',
                severity: 'critical',
                reason: 'Risk score exceeded blocking threshold',
                evidence: $signals,
            ));

            abort(Response::HTTP_FORBIDDEN, 'Access blocked due to security risk.');
        }

        if ($result->requireMfa && $request->hasSession()) {
            $request->session()->put('security:mfa_required', true);
        }

        return $next($request);
    }
}
