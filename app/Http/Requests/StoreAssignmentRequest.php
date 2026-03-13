<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Importante importar esta clase
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Validamos 'departments_id' pero verificando que la dupla con 'positions_id' sea única
            'departments_id' => [
                'required',
                'exists:departments,id',
                Rule::unique('assignments')->where(function ($query) {
                    return $query->where('positions_id', $this->positions_id);
                }),
            ],
            'positions_id' => 'required|exists:positions,id',
        ];
    }

    // Personaliza el mensaje para que el error sea claro en Postman
    public function messages(): array
    {
        return [
            'departments_id.unique' => 'Esta combinación de Departamento y Cargo ya existe en el catálogo.',
        ];
    }
}
