<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\EmployeeController;
use App\Http\Controllers\api\CompanyController;
use App\Http\Controllers\api\BranchController;
use App\Http\Controllers\api\DepartmentController;
use App\Http\Controllers\api\PositionController;
use App\Http\Controllers\api\AssignmentController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResources([
    'employees'   => EmployeeController::class,
    'companies'   => CompanyController::class,
    'branches'    => BranchController::class,
    'departments' => DepartmentController::class,
    'positions'   => PositionController::class,
    'assignments' => AssignmentController::class,
]);
