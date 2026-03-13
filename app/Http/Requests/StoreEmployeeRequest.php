<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // IMPORTANTE: Agrega esta línea

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|min:3|max:255',
            'birthday' => 'required|date|before:today',
            'estado'   => 'required|boolean',

            // FORZAMOS EL ESQUEMA CON CORCHETES (Sintaxis nativa de SQL Server)
            'assignments_id' => 'required|exists:sqlsrv.assignments,id',
            'branch_id'      => 'required|exists:branches,id',
        ];
    }
}
