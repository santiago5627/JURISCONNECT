<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Aquí agregas esto:
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable();
        });
    }

    public function down(): void
    {
        // Aquí puedes agregar esto:
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("photo");
        });
    }
};
