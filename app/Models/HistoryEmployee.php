<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class HistoryEmployee extends Model
{

    protected $fillable = [
        'cedula',
        'nombre',
        'centro_costo',
        'puesto',
        'empresa_code',
        'fecha_ingreso',
        'fecha_envio',
    ];


    protected $casts = [
        'fecha_ingreso' => 'date',
        'fecha_envio'   => 'datetime',
    ];


    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'empresa_code', 'code');
    }


    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ? mb_convert_case($value, MB_CASE_TITLE, "UTF-8") : '',
            set: fn(?string $value) => $value ? mb_strtoupper($value, "UTF-8") : '',
        );
    }
}
