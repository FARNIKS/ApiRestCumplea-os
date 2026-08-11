<?php

namespace App\Http\Resources\Employees;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewEmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'cedula'        => $this->cedula, // 👈 Expuesto al frontend
            'nombre'        => $this->nombre,
            'centro_costo'  => $this->centro_costo,
            'puesto'        => $this->puesto,
            'enviado'       => (bool) $this->enviado,
            'fecha_ingreso' => $this->fecha_ingreso?->format('Y-m-d'), // 👈 Expuesto al frontend
            'empresa' => [
                'codigo' => $this->empresa_code,
                'nombre' => $this->branch?->company_name ?? 'Sin Empresa',
                'pais'   => $this->branch?->country?->name ?? 'Sin País',
            ],
            'creado_el'     => $this->created_at?->format('Y-m-d'),
        ];
    }
}
