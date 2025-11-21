<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('concepto_juridicos', function (Blueprint $table) {
            $table->foreignId('proceso_id')->after('abogado_id')->constrained('procesos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('concepto_juridicos', function (Blueprint $table) {
            $table->dropForeign(['proceso_id']);
            $table->dropColumn('proceso_id');
        });
    }
};