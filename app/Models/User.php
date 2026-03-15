<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Asegúrate de tener esta línea para React

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    // Añadimos HasApiTokens para la autenticación de la API
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // <--- AGREGAMOS ESTA COLUMNA
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Método Senior para verificar si es administrador rápidamente.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
