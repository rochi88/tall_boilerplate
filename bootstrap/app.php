<?php

declare(strict_types=1);

use App\Modules\Security\Http\Middleware\IPAuthorizationMiddleware;
use App\Modules\Security\Http\Middleware\PhishingDetectionMiddleware;
use App\Modules\Security\Http\Middleware\RiskEvaluationMiddleware;
use App\Support\APIResponse;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        apiPrefix: '',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->appendToGroup('ip.authorized', [IPAuthorizationMiddleware::class]);
        $middleware->appendToGroup('risk.evaluate', [RiskEvaluationMiddleware::class]);
        $middleware->appendToGroup('phishing.detect', [PhishingDetectionMiddleware::class]);

        $middleware->validateCsrfTokens(except: [
            'stripe/*',
            'prism/*',
        ]);
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handles cases where a requested resource is not found.
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return APIResponse::showErrorResponse(Response::HTTP_NOT_FOUND);
            }
        });

        // Handles instances where the request method is not allowed for the specified route.
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return APIResponse::showErrorResponse(Response::HTTP_METHOD_NOT_ALLOWED);
            }
        });

        // Catches general HTTP-related exceptions
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return APIResponse::showErrorResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });

        // Captures exceptions related to database queries
        $exceptions->render(function (QueryException $e, Request $request) {
            if ($request->is('api/*')) {
                return APIResponse::showErrorResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });

        // Custom handling for NotAcceptableHttpException rendering.
        $exceptions->render(function (NotAcceptableHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return APIResponse::showErrorResponse(Response::HTTP_NOT_ACCEPTABLE);
            }
        });

        // Customizes the rendering of TooManyRequestsHttpException.
        $exceptions->render(function (TooManyRequestsHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return APIResponse::showErrorResponse(Response::HTTP_TOO_MANY_REQUESTS);
            }
        });
    })->create();
