<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'Core.companies';

    protected $fillable = ['name'];
    // Importante: Laravel no intentará insertar fechas de creación/edición
    public $timestamps = false;

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
