<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateAssignmentRequest extends FormRequest
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
        // Captura el ID de la ruta independientemente de cómo se llame el parámetro
        $assignmentId = $this->route('assignment') ?? $this->route('id');

        return [
            'departments_id' => [
                'required',
                'exists:departments,id',
                // Regla Única Compuesta: Verifica que la pareja Dept/Cargo no se repita
                Rule::unique('assignments', 'departments_id')
                    ->where(function ($query) {
                        return $query->where('positions_id', $this->positions_id);
                    })
                    ->ignore($assignmentId), // Ignora el registro actual para permitir "guardar sin cambios"
            ],
            'positions_id' => [
                'required',
                'exists:positions,id',
            ],
        ];
    }

    /**
     * Mensajes personalizados para que Postman se vea profesional
     */
    public function messages(): array
    {
        return [
            'departments_id.unique' => 'Esta combinación de Departamento y Cargo ya existe en el catálogo.',
        ];
    }
}
