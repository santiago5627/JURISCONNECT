<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assistants', function (Blueprint $table) {
            $table->id();

            // Relación con users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('nombre');
            $table->string('apellido');
            $table->string('tipo_documento');
            $table->string('numero_documento')->unique();
            $table->string('correo')->unique();
            $table->string('telefono')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assistants');
    }
};
