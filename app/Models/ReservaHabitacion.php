<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReservaHabitacion extends Model
{
    protected $table = 'reservas_habitacion';

    protected $fillable = [
        'cliente',
        'cliente_email',
        'cliente_telefono',
        'habitacion_id',
        'fecha_entrada',
        'fecha_salida'
    ];

    /**
     * Get the room assigned to the booking.
     */
    public function habitacion(): BelongsTo
    {
        return $this->belongsTo(Habitacion::class, 'habitacion_id');
    }

    /**
     * Get the transfer reservation for this booking.
     */
    public function traslado(): HasOne
    {
        return $this->hasOne(ReservaTraslado::class, 'reserva_habitacion_id');
    }
}
