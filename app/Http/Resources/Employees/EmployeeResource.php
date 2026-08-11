<?php

namespace App\Http\Resources\Employees;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'Nombre'       => $this->Nombre,
            'Departamento' => $this->Departamento,
            'Centro_Costo' => $this->{'Centro de costo'},
            'Puesto'       => $this->Puesto,
            'company'      => $this->branch?->company_name ?? 'Sin Empresa',
            'country'      => $this->branch?->country?->name ?? 'Sin País',
            'Empresa'      => $this->Empresa,
            'Cumple'       => $this->Cumple?->format('Y-m-d'),
        ];
    }
}
