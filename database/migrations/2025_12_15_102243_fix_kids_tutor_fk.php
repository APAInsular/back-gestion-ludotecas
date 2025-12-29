<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kids', function (Blueprint $table) {
            // 🔴 eliminar FK antigua (tutors)
            $table->dropForeign('kids_tutor_id_foreign');

            // ✅ crear FK correcta (users)
            $table->foreign('tutor_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('kids', function (Blueprint $table) {
            $table->dropForeign(['tutor_id']);

            // (no recreamos tutors, no tiene sentido volver atrás)
        });
    }
};
