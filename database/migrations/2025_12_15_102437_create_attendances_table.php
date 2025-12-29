<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kid_id')
                ->constrained('kids')
                ->onDelete('cascade');

            $table->foreignId('playroom_id')
                ->constrained('playrooms')
                ->onDelete('cascade');

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('restrict'); // quien registra

            $table->date('date');
            $table->time('entry_time')->nullable();
            $table->time('exit_time')->nullable();

            $table->timestamps();

            // Evita dos asistencias abiertas el mismo día
            $table->unique(['kid_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
