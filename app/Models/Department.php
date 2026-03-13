<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = ['name'];

    // Añade esta línea:
    public $timestamps = false;

    public function assignments()
    {
        // Asegúrate de poner 'departments_id' (con la 's')
        return $this->hasMany(Assignment::class, 'departments_id');
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            // Al obtenerlo: "RECURSOS HUMANOS" -> "Recursos Humanos"
            get: fn(string $value) => mb_convert_case($value, MB_CASE_TITLE, "UTF-8"),

            // Al guardarlo: "recursos humanos" -> "RECURSOS HUMANOS"
            set: fn(string $value) => mb_strtoupper($value, "UTF-8"),
        );
    }
}
