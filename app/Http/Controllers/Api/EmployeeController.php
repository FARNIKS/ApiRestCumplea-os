<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Http\Resources\Json\JsonResource;



class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cargamos la rama y la jerarquía de la asignación (puesto y depto)
        $employees = Employee::with([
            'branch.company',
            'assignment'
        ])->paginate(15);

        return EmployeeResource::collection($employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        // 1. Creamos
        $employee = Employee::create($request->validated());

        // 2. Cargamos (IMPORTANTE: Debe ser el nombre del método en el modelo)
        // Usamos el punto para entrar a los hijos de assignment
        $employee->load(['branch.company', 'assignment.position', 'assignment.department']);

        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        // Cargamos relaciones para el empleado específico
        $employee->load(['branch.company', 'assignment.position', 'assignment.department']);

        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): JsonResource
    {
        // 1. Actualizar con los datos validados
        $employee->update($request->validated());

        // 2. Refrescar y cargar relaciones (Igual que en el store)
        $employee->refresh();
        $employee->load(['branch.company', 'assignment.position', 'assignment.department']);

        // 3. Retornar el recurso actualizado
        return new EmployeeResource($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
