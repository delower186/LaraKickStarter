<?php
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        /**
         * custom exceptions for api response
         * @delower
         */
        $exceptions->renderable(function (BindingResolutionException $e, $request) {

            if ($request->is('api/*')) {

                return response()->json([
                    'success'=> false,
                    'message'=> $e->getMessage()
                ],500);

            }
        });

        $exceptions->renderable(function (MethodNotAllowedHttpException $e, $request) {

            if ($request->is('api/*')) {

                return response()->json([
                    'success'=> false,
                    'message'=> $e->getMessage()
                ],405);

            }
        });

        $exceptions->renderable(function (NotFoundHttpException $e, $request) {

            if ($request->is('api/*')) {

                return response()->json([
                    'success'=> false,
                    'message'=> $e->getMessage()
                ],status: 404);

            }
        });

        $exceptions->renderable(function (AuthenticationException $e, $request) {

            if ($request->is('api/*')) {

                return response()->json([
                    'success'=> false,
                    'message'=> $e->getMessage()
                ],401);

            }
        });

        $exceptions->renderable(function (AccessDeniedHttpException $e, $request) {

            if ($request->is('api/*')) {

                return response()->json([
                    'success'=> false,
                    'message'=> $e->getMessage()
                ],403);

            }
        });
    })->create();
