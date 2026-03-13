<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Http\Requests\StoreAssignmentRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\AssignmentResource;
use Illuminate\Http\JsonResponse;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with(['position', 'department'])
            ->join('departments', 'assignments.departments_id', '=', 'departments.id')
            ->join('positions', 'assignments.positions_id', '=', 'positions.id')
            ->orderBy('departments.name')
            ->select('assignments.*')
            ->get();

        // Agrupamos por departamento para el Frontend (Select grouped options)
        $grouped = $assignments->groupBy(fn($asig) => $asig->department->name);

        return response()->json(
            $grouped->map(fn($items, $dept) => [
                'label'   => $dept,
                'options' => AssignmentResource::collection($items)
            ])->values()
        );
    }

    public function store(StoreAssignmentRequest $request): JsonResponse
    {
        try {
            // Envolvemos en una transacción para que SQL Server mantenga la consistencia [4]
            return DB::transaction(function () use ($request) {

                // 1. Lógica de "Encontrar o Crear": 
                // Si la pareja ya existe, la recupera; si no, la crea en un solo paso.
                // Esto elimina la dependencia manual de verificar el ID antes de insertar.
                $assignment = Assignment::firstOrCreate(
                    [
                        'departments_id' => $request->departments_id,
                        'positions_id'   => $request->positions_id,
                    ]
                );

                // 2. Carga de relaciones para la respuesta JSON
                // Aprovechamos el Eager Loading para obtener nombres formateados (Título) [5]
                $assignment->load(['department', 'position']);

                // 3. Respuesta estandarizada para el frontend de React [6, 7]
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Vínculo de catálogo procesado correctamente',
                    'data'    => new AssignmentResource($assignment)
                ], 201); // Código 201: Recurso creado exitosamente [8]
            });
        } catch (\Exception $e) {
            // Captura errores técnicos de SQL Server (ej. caídas de conexión) [9]
            return response()->json([
                'status'  => 'error',
                'message' => 'No se pudo procesar la asignación en el catálogo central',
                'info'    => $e->getMessage()
            ], 500);
        }
    }
}
