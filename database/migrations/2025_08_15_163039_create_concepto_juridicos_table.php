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
            $table->string('titulo');
            //$table->string('categoria');
            $table->text('descripcion');
            
            // Relación con abogado (antes de timestamps)
            $table->foreignId('abogado_id')->constrained('users')->onDelete('cascade');
            
            // timestamps siempre al final
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Corrección: debe coincidir con el nombre de la tabla creada
        Schema::dropIfExists('concepto_juridicos');
    }
};