<?php

declare(strict_types=1);

namespace App\Modules\Security;

use App\Modules\Security\Services\RuleBasedRiskEngine;
use App\Providers\ModuleServiceProvider;
use App\Support\Security\RiskEngineInterface;
use Override;

final class SecurityServiceProvider extends ModuleServiceProvider
{
    protected string $module = 'Security';

    #[Override]
    public function register(): void
    {
        $this->basePath = __DIR__;

        /*
        |--------------------------------------------------------------------------
        | Bind Risk Engine
        |--------------------------------------------------------------------------
        */
        $this->app->bind(
            RiskEngineInterface::class,
            RuleBasedRiskEngine::class,
        );

        /*
        |--------------------------------------------------------------------------
        | Register module event listeners (conditionally)
        |--------------------------------------------------------------------------
        */
        if ($this->securityEnabled()) {            
            $this->app->register(SecurityEventServiceProvider::class);            
        }
    }

    private function securityEnabled(): bool
    {
        return config('security.enabled', false) === true;
        // return (config('security.enabled', false) === true) && app()->environment('production');
    }
}
