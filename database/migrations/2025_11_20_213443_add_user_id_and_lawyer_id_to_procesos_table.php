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
        Schema::table('procesos', function (Blueprint $table) {
            // Agregar campos
            $table->unsignedBigInteger('user_id')->nullable()->after('estado');
            $table->unsignedBigInteger('lawyer_id')->nullable()->after('user_id');

            // Foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('lawyer_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['lawyer_id']);
            $table->dropColumn(['user_id', 'lawyer_id']);
        });
    }
};
