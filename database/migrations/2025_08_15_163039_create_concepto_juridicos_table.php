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
        $table->string('categoria');
        $table->text('descripcion');
        $table->timestamps();
            
            
            
        });
    }

};
