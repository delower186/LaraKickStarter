<?php

use App\Http\Middleware\Role;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
       /**
        * New method to achieve API versioning from Laravel 11
        * @delower
        */
        apiPrefix:'api/v1',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => Role::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        /**
         * custom exceptions for api response
         * @delower
         */
        $exceptions->renderable(function (InternalErrorException $e, $request) {

            if ($request->is('api/*')) {

                return response()->json([
                    'success'=> false,
                    'message'=> 'Internal Server Error. Please try again later.'
                ],500);

            }
        });

        $exceptions->renderable(function (NotFoundResourceException $e, $request) {

            if ($request->is('api/*')) {

                return response()->json([
                    'success'=> false,
                    'message'=> 'Internal Server Error. Please try again later.'
                ],status: 404);

            }
        });

        $exceptions->renderable(function (AuthenticationException $e, $request) {

            if ($request->is('api/*')) {

                return response()->json([
                    'success'=> false,
                    'message'=> 'Token authentication unsuccessful!'
                ],401);

            }
        });
    })->create();
