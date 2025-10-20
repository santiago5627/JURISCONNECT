<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('concepto_juridicos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_radicado')->unique();
            $table->string('tipo_proceso');
            $table->string('demandante');
            $table->string('demandado');
            $table->date('fecha_radicacion')->nullable();
            $table->enum('estado', ['Pendiente', 'En curso', 'Finalizado'])->default('Pendiente');
            
            // Relación con abogado
            $table->foreignId('abogado_id')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

};