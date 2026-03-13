<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sucursal' => $this->country,
            // Aquí traemos el nombre de la empresa, no solo el ID
            'empresa' => $this->company->name ?? 'Sin empresa',
            'total_empleados' => $this->total_staff ?? 0,
            'empresa_id' => $this->company_id,
        ];
    }
}
