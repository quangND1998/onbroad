<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
        //     if ($request->is('api/*')) {
        //         return response()->json([
        //                         'responseMessage' => 'You do not have the required authorization.',
        //                         'responseStatus'  => 403,
        //                     ],403);
        //     }
        // });

        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                                'responseMessage' => 'API Not Found.',
                                'responseStatus'  => 404,
                            ],404);
            }
        });
        $exceptions->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                                'responseMessage' => 'Method not allowed.',
                                'responseStatus'  => 405,
                            ],405);
            }
        });
    })->create();
