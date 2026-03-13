<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    public function index()
    {
        return CompanyResource::collection(Company::orderBy('name', 'asc')->get());
    }

    public function store(StoreCompanyRequest $request): JsonResponse
    {
        try {
            $company = Company::create($request->validated());
            return response()->json([
                'status' => 'success',
                'data'   => new CompanyResource($company)
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'info' => $e->getMessage()], 500);
        }
    }


    public function update(UpdateCompanyRequest $request, $id): JsonResponse
    {
        try {
            $company = Company::findOrFail($id);
            $company->update($request->validated());
            return response()->json([
                'status' => 'success',
                'data'   => new CompanyResource($company)
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'info' => $e->getMessage()], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $company = Company::findOrFail($id);

            // Restricción: No borrar si la empresa tiene sucursales registradas
            if ($company->branches()->exists()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'No se puede eliminar: La empresa tiene sucursales vinculadas.'
                ], 400);
            }

            $company->delete();
            return response()->json(['status' => 'success', 'message' => 'Empresa eliminada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'info' => $e->getMessage()], 500);
        }
    }
}
