<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lawyers', function (Blueprint $table) {
            $table->string('telefono')->nullable();
            $table->string('especialidad')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('lawyers', function (Blueprint $table) {
            $table->dropColumn('telefono');
            $table->dropColumn('especialidad');
        });
    }
};
