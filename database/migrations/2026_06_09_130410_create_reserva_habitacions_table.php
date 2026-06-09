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
        Schema::create('reservas_habitacion', function (Blueprint $table) {
            $table->id();
            $table->string('cliente');
            $table->string('cliente_email');
            $table->string('cliente_telefono');
            $table->foreignId('habitacion_id')->constrained('habitaciones')->onDelete('cascade');
            $table->date('fecha_entrada');
            $table->date('fecha_salida');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas_habitacion');
    }
};
