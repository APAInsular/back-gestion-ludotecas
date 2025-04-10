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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
    
            $table->string('municipality', 100);  // Municipio
            $table->string('locality', 100);      // Localidad o colonia
            $table->string('zip_code', 10);       // Código postal
            // Agrega los campos que necesites (calle, número exterior, etc.)
    
            $table->timestamps();
    
            // Clave foránea, asumiendo que tu tabla de usuarios se llama "users"
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
