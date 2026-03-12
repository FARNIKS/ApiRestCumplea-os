<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BirthdayMessage extends Model
{

    // 1. Especificar el esquema y la tabla correctamente
    protected $table = 'Core.birthday_messages';

    // 2. Definir la llave primaria (importante para que el find(70) funcione)
    protected $primaryKey = 'id';

    // 3. Como es una tabla de consulta de frases, probablemente no tenga columnas 'created_at' y 'updated_at'
    public $timestamps = false;
}
