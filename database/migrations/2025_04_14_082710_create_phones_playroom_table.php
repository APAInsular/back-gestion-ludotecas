<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('phones_playroom', function (Blueprint $table) {
            $table->id();

            // Clave foránea a la tabla playrooms
            $table->unsignedBigInteger('playroom_id');

            // Campos para el teléfono
            $table->string('number', 20);    // número de teléfono
            $table->string('label')->nullable();
            // label podría ser “principal”, “emergencia”, etc., si lo deseas

            // Marca de tiempo
            $table->timestamps();

            // Añadimos la clave foránea
            $table->foreign('playroom_id')
                ->references('id')->on('playrooms')
                ->onDelete('cascade');
            // onDelete('cascade') => si se borra la Playroom, se borran sus phones
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phones_playroom');
    }
};
