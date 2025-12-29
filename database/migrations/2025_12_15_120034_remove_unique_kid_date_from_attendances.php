<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {

            // 1️⃣ Eliminar foreign key
            $table->dropForeign(['kid_id']);

            // 2️⃣ Eliminar índice unique
            $table->dropUnique(['kid_id', 'date']);

            // 3️⃣ Volver a crear foreign key
            $table->foreign('kid_id')
                ->references('id')
                ->on('kids')
                ->onDelete('cascade');

            // 4️⃣ Crear índice normal (NO unique)
            $table->index(['kid_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {

            // rollback
            $table->dropIndex(['kid_id', 'date']);
            $table->dropForeign(['kid_id']);

            $table->unique(['kid_id', 'date']);

            $table->foreign('kid_id')
                ->references('id')
                ->on('kids')
                ->onDelete('cascade');
        });
    }
};
