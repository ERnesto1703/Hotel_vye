<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Camioneta extends Model
{
    protected $table = 'camionetas';

    protected $fillable = ['placa', 'capacidad'];

    /**
     * Get the transfers assigned to the shuttle.
     */
    public function traslados(): HasMany
    {
        return $this->hasMany(ReservaTraslado::class, 'camioneta_id');
    }
}
