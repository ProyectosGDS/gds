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
        Schema::create('ev_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_evento_id')
                  ->constrained('tipo_eventos');
            $table->unsignedBigInteger('direccion_id');
            $table->string('titulo', 50);
            $table->string('descripcion', 250);
            $table->string('ubicacion', 100);
            $table->date('fecha');
            $table->string('hora_inicial');
            $table->string('hora_final');
            $table->string('responsable');

            $table->foreign('direccion_id')->references('id')->on('di_direcciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ev_eventos');
    }
};
