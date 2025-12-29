<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kids', function (Blueprint $table) {
            $table->foreignId('dni_id')
                ->nullable()
                ->after('tutor_id')
                ->constrained('dnis')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kids', function (Blueprint $table) {
            $table->dropForeign(['dni_id']);
            $table->dropColumn('dni_id');
        });
    }
};
