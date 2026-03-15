<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\api\EmployeeController;
use App\Http\Controllers\api\BranchController;
use App\Http\Controllers\api\CompanyController;
use App\Http\Controllers\api\DepartmentController;
use App\Http\Controllers\api\PositionController;
use App\Http\Controllers\api\AssignmentController;

// Grupo de API Version 1
Route::prefix('v1')->group(function () {

    // Ruta pública para el acceso inicial
    Route::post('/login', [AuthController::class, 'login']);

    // Rutas protegidas por tokens de Sanctum [3, 4]
    Route::middleware('auth:sanctum')->group(function () {

        // Endpoint de identidad para React
        Route::get('/user', function (Request $request) {
            return new \App\Http\Resources\UserResource($request->user());
        });

        // Recursos CRUD centralizados (excluye rutas de formularios Blade) [2, 5]
        Route::apiResources([
            'employees'   => EmployeeController::class,
            'companies'   => CompanyController::class,
            'branches'    => BranchController::class,
            'departments' => DepartmentController::class,
            'positions'   => PositionController::class,
            'assignments' => AssignmentController::class,
        ]);

        // Ruta segura para cerrar sesión
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
