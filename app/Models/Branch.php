<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    protected $table = 'Core.branches';
    // Importante: Laravel no intentará insertar fechas de creación/edición
    public $timestamps = false;

    protected $fillable = ['name', 'code', 'country', 'company_id'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
