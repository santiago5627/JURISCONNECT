<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assistant_lawyer', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assistant_id')
                  ->constrained('assistants')
                  ->onDelete('cascade');

            $table->foreignId('lawyer_id')
                  ->constrained('lawyers')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assistant_lawyer');
    }
};
    