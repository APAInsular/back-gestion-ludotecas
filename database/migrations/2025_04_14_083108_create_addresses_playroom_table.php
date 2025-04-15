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
        Schema::create('addresses_playroom', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('playroom_id');
            $table->string('street', 255);      // Calle
            $table->string('municipality', 100);  // Municipio
            $table->string('locality', 100);      // Localidad o colonia
            $table->string('zip_code', 10);   // Código postal
            $table->string('country', 100);
            $table->string('province', 100);
            // Estado o provincia
            // Agrega los campos que necesites (calle, número exterior, etc.)

            $table->timestamps();

            // Clave foránea, asumiendo que tu tabla de usuarios se llama "users"
            $table->foreign('playroom_id')->references('id')->on('playrooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adresses_playroom');
    }
};
