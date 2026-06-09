<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habitacion extends Model
{
    protected $table = 'habitaciones';

    protected $fillable = ['numero', 'tipo', 'precio', 'estado'];

    /**
     * Get the bookings for the room.
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(ReservaHabitacion::class, 'habitacion_id');
    }
}
