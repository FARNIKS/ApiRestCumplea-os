<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'fullName'   => $this->name,
            'birthday'   => $this->birthday?->format('Y-m-d'), // Protección en la fecha
            'isActive'   => $this->estado,

            'assignment' => [
                'position'   => $this->assignment?->position?->name ?? 'No Position',
                'department' => $this->assignment?->department?->name ?? 'General',
            ],

            // Protección en relaciones de un nivel
            'branch' => [
                'name'   => $this->branch?->code,
                'country' => $this->branch?->country,
                'company' => $this->branch?->company?->name,
            ],


        ];
    }
}
