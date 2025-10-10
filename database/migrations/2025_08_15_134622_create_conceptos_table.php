<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('conceptos', function (Blueprint $table) {
        $table->id();
            $table->string('numero_radicado')->unique();
            $table->string('tipo_proceso');
            $table->string('demandante');
            $table->string('demandado');
            $table->date('fecha_radicacion')->nullable();
            $table->enum('estado', ['pendiente', 'en curso', 'finalizado'])->default('pendiente');

            // Relación con abogado
            $table->foreignId('abogado_id')->constrained('users')->onDelete('cascade');
    });
}


    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conceptos');
    }
};
