<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Log;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $exception, Request $request) {

            Log::channel('admin')->error($exception->getMessage(), $request->all());

            if ($request->is('api/*')) {
                return ApiResponse::error($exception->getMessage(), $exception->errors());
            }
        });

        $exceptions->render(function (QueryException $exception, Request $request) {

            Log::channel('admin')->error($exception->getMessage(), $request->all());

            if ($request->is('api/*')) {
                return ApiResponse::error($exception->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });

        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {

            Log::channel('admin')->error($exception->getMessage(), $request->all());

            if ($request->is('api/*')) {
                return ApiResponse::error($exception->getMessage(), [], Response::HTTP_NOT_FOUND);
            }
        });

    })->create();
