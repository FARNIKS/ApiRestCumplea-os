<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
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
            'departamento' => $this->department->name ?? 'N/A',
            'cargo' => $this->position->name ?? 'N/A',
            'depto_id' => $this->departments_id,
            'cargo_id' => $this->positions_id,
        ];
    }
}
