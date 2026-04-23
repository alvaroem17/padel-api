<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    /**
     * Campos asignables masivamente
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Relación: Una cancha tiene muchas reservas
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
