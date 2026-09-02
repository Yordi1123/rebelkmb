<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'activo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'activo'            => 'boolean',
        ];
    }

    /**
     * Verifica si el usuario tiene un rol específico.
     * Útil para gates y políticas en futuras iteraciones.
     */
    public function hasRol(string $rol): bool
    {
        return $this->rol === $rol;
    }

    /**
     * Verifica si el usuario es administrador.
     */
    public function esAdministrador(): bool
    {
        return $this->rol === 'administrador';
    }

    // Relaciones con tablas del sistema (se activarán en futuras ramas)
    // public function lotes() { return $this->hasMany(Lote::class); }
    // public function preinóculos() { return $this->hasMany(Preinoculo::class); }
    // public function controlPh() { return $this->hasMany(ControlPh::class); }
}
