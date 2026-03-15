<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /**
         * Usamos el operador null-safe (?->) para evitar errores si el usuario es nulo.
         * Esto verifica si el usuario existe y si tiene el rol de administrador.
         */
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Usamos 'sometimes' para que solo valide si el campo viene en el JSON (PATCH)
        return [
            'name'            => 'sometimes|string|min:3|max:255',
            'birthday'        => 'sometimes|date|before:today',
            'estado'          => 'sometimes|boolean',
            'assignments_id'  => 'sometimes|exists:sqlsrv.assignments,id',
            'branch_id'       => 'sometimes|exists:branches,id'
        ];
    }
}
