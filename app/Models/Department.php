<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'Core.departments';

    protected $fillable = ['name'];
    // Importante: Laravel no intentará insertar fechas de creación/edición
    public $timestamps = false;

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
