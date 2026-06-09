<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservaTraslado extends Model
{
    protected $table = 'reservas_traslado';

    protected $fillable = [
        'reserva_habitacion_id',
        'camioneta_id',
        'fecha_hora',
        'num_pasajeros',
        'tipo'
    ];

    /**
     * Get the room booking that requested this transfer.
     */
    public function reservaHabitacion(): BelongsTo
    {
        return $this->belongsTo(ReservaHabitacion::class, 'reserva_habitacion_id');
    }

    /**
     * Get the shuttle assigned to the transfer.
     */
    public function camioneta(): BelongsTo
    {
        return $this->belongsTo(Camioneta::class, 'camioneta_id');
    }
}
