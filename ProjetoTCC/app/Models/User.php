<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'co2_consumido', // Adicionado
        'co2_meta',      // Adicionado
        'data_registro_co2', // Adicionado
        'fonte_emissao_co2', // Adicionado
        'observacoes_co2', // Adicionado
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
            'password' => 'hashed',
            'co2_consumido' => 'decimal:2', // Adicionado cast para decimal
            'co2_meta' => 'decimal:2',      // Adicionado cast para decimal
            'data_registro_co2' => 'datetime', // Adicionado cast para datetime
        ];
    }
}

