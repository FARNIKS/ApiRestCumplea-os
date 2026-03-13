<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Http\Resources\PositionResource;
use Illuminate\Http\JsonResponse;

class PositionController extends Controller
{
    public function index()
    {
        // Recupera los cargos y cuenta sus vínculos en una sola consulta SQL
        $positions = Position::withCount('assignments')
            ->orderBy('name', 'asc')
            ->get();

        return PositionResource::collection($positions);
    }

    public function store(StorePositionRequest $request): JsonResponse
    {
        try {
            $position = Position::create($request->validated());
            return response()->json([
                'status' => 'success',
                'data'   => new PositionResource($position)
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'info' => $e->getMessage()], 500);
        }
    }

    public function update(UpdatePositionRequest $request, $id): JsonResponse
    {
        try {
            $position = Position::findOrFail($id);
            $position->update($request->validated());
            return response()->json([
                'status' => 'success',
                'data'   => new PositionResource($position)
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'info' => $e->getMessage()], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $position = Position::findOrFail($id);

            // Restricción: No borrar si el cargo existe en alguna combinación de la tabla assignments
            if ($position->assignments()->exists()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'No se puede eliminar: Este cargo está siendo usado en el catálogo.'
                ], 400);
            }

            $position->delete();
            return response()->json(['status' => 'success', 'message' => 'Cargo eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'info' => $e->getMessage()], 500);
        }
    }
}
