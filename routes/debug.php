<?php

declare(strict_types=1);

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'debug',
], function (): void {
    if (app()->isLocal()) {
        Route::get('/container-bindings', function (): void {
            // return response()->json(app()->getBindings());
            dd(app()->getBindings());
        });

        Route::get('/logs', function () {
            $logFile = storage_path('logs/laravel.log');

            if (file_exists($logFile)) {
                return response()->file($logFile);
            }

            return response()->json(['message' => 'Log file not found.'], 404);
        });

        Route::get('/config', fn() => response()->json(config()->all()));

        Route::get('/routes', function () {
            $routes = collect(Route::getRoutes())->map(fn($route) => [
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'action' => $route->getActionName(),
                'methods' => $route->methods(),
                'middleware' => $route->gatherMiddleware(),
            ]);

            return response()->json($routes);
        });

        Route::get('/env', fn() => response()->json([
            'environment' => app()->environment(),
            'debug' => config('app.debug'),
        ]));

        Route::get('/cache-clear', function () {
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
            \Artisan::call('view:clear');

            return response()->json(['message' => 'Application cache cleared.']);
        });

        Route::get('/phpinfo', function (): ResponseFactory|Response {
            ob_start();
            phpinfo();
            $phpinfo = ob_get_clean();

            return response($phpinfo);
        });

        Route::get('/health', fn() => response()->json(['status' => 'OK', 'timestamp' => now()]));

        Route::get('/db-test', function () {
            try {
                \DB::connection()->getPdo();

                return response()->json(['database_connection' => 'successful']);
            } catch (\Exception $exception) {
                return response()->json(['database_connection' => 'failed', 'error' => $exception->getMessage()], 500);
            }
        });

        Route::get('/cache-status', function () {
            $cacheStore = config('cache.default');

            return response()->json(['cache_store' => $cacheStore]);
        });

        Route::get('/session-status', function (Request $request) {
            $sessionId = $request->session()->getId();

            return response()->json(['session_id' => $sessionId]);
        });

        Route::get('/queue-status', function () {
            $queueConnection = config('queue.default');

            return response()->json(['queue_connection' => $queueConnection]);
        });

        Route::get('/mail-status', function () {
            $mailDriver = config('mail.default');

            return response()->json(['mail_driver' => $mailDriver]);
        });

        Route::get('/app-status', fn() => response()->json([
            'app_name' => config('app.name'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'app_url' => config('app.url'),
        ]));

        Route::get('/services-status', fn() => response()->json([
            'services' => [
                'database' => \DB::connection()->getDatabaseName() ? 'connected' : 'not connected',
                'cache' => cache()->getStore() ? 'available' : 'not available',
                'session' => session()->isStarted() ? 'active' : 'inactive',
            ],
        ]));

        Route::get('/timezone', fn() => response()->json(['app_timezone' => config('app.timezone'), 'current_time' => now()->toDateTimeString()]));

        Route::get('/locale', fn() => response()->json(['app_locale' => app()->getLocale()]));

        Route::get('/storage-link', function () {
            $linkPath = public_path('storage');
            $targetPath = storage_path('app/public');

            if (file_exists($linkPath)) {
                return response()->json(['message' => 'Storage link already exists.']);
            }

            \Artisan::call('storage:link');

            return response()->json(['message' => 'Storage link created successfully.']);
        });

        Route::get('/app-key', fn() => response()->json(['app_key' => config('app.key')]));

    }
});
