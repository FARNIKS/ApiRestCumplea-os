<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
        return [
            'code'       => 'sometimes|string|max:255',
            'company_id' => 'sometimes|exists:companies,id',
            'country'    => 'sometimes|string|max:255',
            'total_staff' => 'sometimes|integer',
        ];
    }
}
