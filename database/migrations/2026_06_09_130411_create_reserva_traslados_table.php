<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservas_traslado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserva_habitacion_id')->constrained('reservas_habitacion')->onDelete('cascade');
            $table->foreignId('camioneta_id')->constrained('camionetas')->onDelete('cascade');
            $table->dateTime('fecha_hora');
            $table->integer('num_pasajeros');
            $table->string('tipo'); // 'check-in', 'check-out'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas_traslado');
    }
};
