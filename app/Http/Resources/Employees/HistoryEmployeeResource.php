<?php

namespace App\Http\Resources\Employees;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryEmployeeResource extends JsonResource
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
            'cedula'        => $this->cedula,
            'nombre'        => $this->nombre,
            'centro_costo'  => $this->centro_costo,
            'puesto'        => $this->puesto,
            'fecha_ingreso' => $this->fecha_ingreso ? $this->fecha_ingreso->format('Y-m-d') : null,
            'empresa' => [
                'codigo' => $this->empresa_code,
                'nombre' => $this->branch?->company_name ?? 'Sin Empresa',
                'pais'   => $this->branch?->country?->name ?? 'Sin País',
            ],

            'fecha_envio'   => $this->fecha_envio ? $this->fecha_envio->format('Y-m-d') : null,
        ];
    }
}
