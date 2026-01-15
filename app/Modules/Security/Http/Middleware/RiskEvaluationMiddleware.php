<?php

declare(strict_types=1);

namespace App\Modules\Security\Http\Middleware;

use App\Modules\Security\Events\RiskEvaluated;
use App\Modules\Security\Events\RiskFlagRaised;
use App\Support\Security\RiskEngineInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class RiskEvaluationMiddleware
{
    public function __construct(
        private RiskEngineInterface $riskEngine,
    ) {}

    /**
     * Evaluate request risk and enforce security decisions.
     *
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $signals = $this->collectSignals($request);

        $result = $this->riskEngine->evaluate($signals);

        /* -------------------------------------------------
         | Emit evaluation event (async persistence)
         |-------------------------------------------------*/
        event(new RiskEvaluated(
            userId: optional($request->user())->id,
            ip: (string) $request->ip(),
            score: $result->score,
            flags: $result->flags,
            signals: $signals,
        ));

        /* -------------------------------------------------
         | Enforcement (sync, fail-closed)
         |-------------------------------------------------*/
        if ($result->block === true) {
            event(new RiskFlagRaised(
                userId: optional($request->user())->id,
                flagType: 'risk_engine',
                severity: 'critical',
                reason: 'Risk score exceeded blocking threshold',
                evidence: $signals,
            ));

            abort(
                Response::HTTP_FORBIDDEN,
                'Access blocked due to elevated security risk.'
            );
        }

        /* -------------------------------------------------
         | Step-up authentication (MFA)
         |-------------------------------------------------*/
        if ($result->requireMfa === true && $request->hasSession()) {
            $request->session()->put('security:mfa_required', true);
        }

        return $next($request);
    }

    /**
     * Collect deterministic risk signals from request context.
     */
    private function collectSignals(Request $request): array
    {
        return [
            // Identity
            'is_authenticated' => $request->user() !== null,

            // Network
            'ip_address'       => $request->ip(),
            'ip_reputation'    => $request->attributes->get('ip_reputation'),

            // Device / Behaviour
            'is_new_device'    => (bool) $request->attributes->get('is_new_device', false),
            'geo_mismatch'     => (bool) $request->attributes->get('geo_mismatch', false),

            // Request context
            'route'            => optional($request->route())->getName(),
            'method'           => $request->method(),
            'is_api'           => $request->expectsJson(),

            // Auth history
            'failed_attempts'  => (int) $request->attributes->get('failed_attempts', 0),
        ];
    }
}
