<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    public function index()
    {
        // Eager loading para evitar consultas N+1
        $employees = Employee::with(['branch.company', 'assignment.position', 'assignment.department'])
            ->paginate(15);

        return EmployeeResource::collection($employees);
    }

    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        try {
            // El incremento de 'total_staff' ocurre automáticamente en el modelo (booted)
            $employee = Employee::create($request->validated());
            $employee->load(['branch.company', 'assignment.position', 'assignment.department']);

            return response()->json([
                'status' => 'success',
                'message' => 'Empleado creado exitosamente',
                'data'   => new EmployeeResource($employee)
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'info' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): JsonResponse
    {
        try {
            $employee->update($request->validated());
            $employee->refresh()->load(['branch.company', 'assignment.position', 'assignment.department']);

            return response()->json(['status' => 'success', 'message' => 'Empleado actualizado', 'data' => new EmployeeResource($employee)]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'info' => $e->getMessage()], 500);
        }
    }

    public function destroy(Employee $employee): JsonResponse
    {
        try {
            // REGLA: No borramos físicamente al empleado, solo lo desactivamos
            $employee->update(['estado' => false]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Empleado desactivado y personal de sucursal actualizado'
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'info' => $e->getMessage()], 500);
        }
    }
}
