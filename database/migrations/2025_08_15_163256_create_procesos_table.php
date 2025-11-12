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
        Schema::create('procesos', function (Blueprint $table) {
    $table->id();
    $table->string('tipo_proceso', 100);
    $table->string('numero_radicado', 62)->unique();
    $table->string('demandante', 255);
    $table->string('demandado', 255);
    $table->text('descripcion');
    $table->string('documento')->nullable();
    $table->enum('estado', ['Pendiente', 'En curso', 'Finalizado' ])->default('Pendiente');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procesos');
    }
};