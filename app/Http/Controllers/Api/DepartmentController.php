<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    public function index()
    {
        return DepartmentResource::collection(Department::orderBy('name', 'asc')->get());
    }

    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        try {
            $department = Department::create($request->validated());
            return response()->json([
                'status' => 'success',
                'data'   => new DepartmentResource($department)
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'info' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateDepartmentRequest $request, $id): JsonResponse
    {
        try {
            $department = Department::findOrFail($id);
            $department->update($request->validated());
            return response()->json([
                'status' => 'success',
                'data'   => new DepartmentResource($department)
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'info' => $e->getMessage()], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $department = Department::findOrFail($id);

            // Restricción: No borrar si el departamento está en el catálogo de asignaciones
            if ($department->assignments()->exists()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'No se puede eliminar: Este departamento tiene cargos asignados.'
                ], 400);
            }

            $department->delete();
            return response()->json(['status' => 'success', 'message' => 'Departamento eliminado']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'info' => $e->getMessage()], 500);
        }
    }
}
