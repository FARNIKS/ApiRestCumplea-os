<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Branch;
use App\Models\Assignment;



class Employee extends Model
{
    protected $table = 'Core.employees'; // Tu esquema de SQL Server

    // Importante: Laravel no intentará insertar fechas de creación/edición
    public $timestamps = false;

    protected $fillable = [
        'name',
        'birthday',
        'branch_id',
        'assignements_id',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean',
        'birthday' => 'date',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class, 'assignements_id');
    }
}
