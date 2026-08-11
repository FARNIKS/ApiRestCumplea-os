<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;


class NewEmployee extends Model
{
    use HasFactory;

    protected $table = "new_employees";

    protected $fillable = [
        'cedula',
        'nombre',
        'centro_costo',
        'puesto',
        'empresa_code',
        'cumple',
        'fecha_ingreso',
        'enviado',
    ];

    protected $casts = [
        'enviado' => 'boolean',
        'cumple' => 'date',
        'fecha_ingreso' => 'date',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'empresa_code', 'code');
    }

    public function employeeByCentroCosto(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'centro_costo', 'Centro de costo');
    }

    public function employeeByPuesto(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'puesto', 'Puesto');
    }

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ? mb_convert_case($value, MB_CASE_TITLE, "UTF-8") : '',
            set: fn(?string $value) => $value ? mb_strtoupper($value, "UTF-8") : '',
        );
    }
}
