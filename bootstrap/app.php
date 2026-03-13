<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // CAPTURAR TODOS LOS ERRORES DE VALIDACIÓN DEL SISTEMA
        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, $request) {
            if ($request->is('api/*')) { // Solo si la ruta empieza por /api/
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Errores de validacion',
                    'errors'  => $e->errors(),
                    'metodo'  => $request->method(),
                ], 422);
            }
        });
    })->create();
