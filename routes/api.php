<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Birthdays\BirthdayConfigController;
use App\Http\Controllers\Api\Birthdays\NoBirthdayConfigController;
use App\Http\Controllers\Api\Employees\EmployeeController;
use App\Http\Controllers\Api\Employees\HistoryEmployeeController;
use App\Http\Controllers\Api\Employees\NewEmployeeController;
use App\Http\Controllers\Api\Location\BranchController;
use App\Http\Controllers\Api\Location\CountryController;
use App\Http\Controllers\Api\NewEmployeeReports\NewEmployeeReportConfigController;
use App\Http\Controllers\Api\NewEmployeeReports\NewEmployeeReportRhConfigController;
use App\Http\Controllers\Api\NewEmployeeReports\NoNewEmployeeReportRhConfigController;
use App\Http\Controllers\Api\Settings\BirthdaySettingsController;
use App\Http\Controllers\Api\Settings\FridayReportSettingsController;
use App\Http\Controllers\Api\Settings\MondayProcessSettingsController;
use App\Http\Resources\UserAcces\UserResource;

Route::prefix('v1')->group(function () {
    Route::view('/documentacion', 'documentacion');
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('user', fn(Request $request) => new UserResource($request->user()));
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('users', [AuthController::class, 'index']);

        Route::get('history-employees', [HistoryEmployeeController::class, 'index']);

        Route::get('new-employees', [NewEmployeeController::class, 'index']);
        Route::get('new-employees/count', [NewEmployeeController::class, 'getCount']);
        Route::get('new-employees/{newEmployee}', [NewEmployeeController::class, 'show']);


        Route::get('employees', [EmployeeController::class, 'index']);
        Route::get('employees/{employee}', [EmployeeController::class, 'show']);

        Route::get('branches', [BranchController::class, 'index']);
        Route::get('branches/{branch}', [BranchController::class, 'show']);

        Route::get('countries', [CountryController::class, 'index']);
        Route::get('countries/{country}', [CountryController::class, 'show']);

        Route::prefix('settings')->group(function () {

            Route::get('status', [BirthdaySettingsController::class, 'index']);
            Route::get('new-employees-friday-status', [FridayReportSettingsController::class, 'index']);
            Route::get('new-employees-monday-status', [MondayProcessSettingsController::class, 'index']);

            Route::get('birthday', [BirthdayConfigController::class, 'index']);
            Route::get('no-birthday', [NoBirthdayConfigController::class, 'index']);

            Route::get('new-employee-report', [NewEmployeeReportConfigController::class, 'index']);
            Route::get('new-employee-report-rh', [NewEmployeeReportRhConfigController::class, 'index']);
            Route::get('no-new-employee-report-rh', [NoNewEmployeeReportRhConfigController::class, 'index']);
        });

        Route::middleware('admin')->group(function () {

            Route::post('register', [AuthController::class, 'register']);
            Route::put('users-status/{user}', [AuthController::class, 'toggleStatus']);
            Route::put('users/{user}', [AuthController::class, 'update']);


            Route::post('/new-employees/sync', [NewEmployeeController::class, 'syncNow']);

            Route::prefix('settings')->group(function () {
                Route::post('toggle-pause', [BirthdaySettingsController::class, 'toggleStatus']);
                Route::post('run-manual-send', [BirthdaySettingsController::class, 'runManualSend']);
                Route::post('new-employees-friday/toggle', [FridayReportSettingsController::class, 'toggleStatus']);
                Route::post('new-employees-friday/run', [FridayReportSettingsController::class, 'runManual']);
                Route::post('new-employees-monday/toggle', [MondayProcessSettingsController::class, 'toggleStatus']);
                Route::post('new-employees-monday/run', [MondayProcessSettingsController::class, 'runManual']);

                Route::put('birthday', [BirthdayConfigController::class, 'update']);
                Route::post('birthday/restore', [BirthdayConfigController::class, 'restore']);
                Route::put('no-birthday', [NoBirthdayConfigController::class, 'update']);
                Route::post('no-birthday/restore', [NoBirthdayConfigController::class, 'restore']);

                Route::put('new-employee-report', [NewEmployeeReportConfigController::class, 'update']);
                Route::post('new-employee-report/restore', [NewEmployeeReportConfigController::class, 'restore']);
                Route::put('new-employee-report-rh', [NewEmployeeReportRhConfigController::class, 'update']);
                Route::post('new-employee-report-rh/restore', [NewEmployeeReportRhConfigController::class, 'restore']);
                Route::put('no-new-employee-report-rh', [NoNewEmployeeReportRhConfigController::class, 'update']);
                Route::post('no-new-employee-report-rh/restore', [NoNewEmployeeReportRhConfigController::class, 'restore']);
            });
        });
    });
});
