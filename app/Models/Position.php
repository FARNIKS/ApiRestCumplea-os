<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'Core.positions';

    protected $fillable = ['name'];
    // Importante: Laravel no intentará insertar fechas de creación/edición
    public $timestamps = false;

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
