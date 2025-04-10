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
    Schema::create('phones', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');

        $table->string('phone', 9);  // Teléfono obligatorio
        $table->string('name', 255); // Teléfono de respaldo (opcional)
        $table->string('firstSurname', 255); // Teléfono de respaldo (opcional)
        $table->string('secondSurname', 255)->nullable(); // Teléfono de respaldo (opcional)
        $table->boolean('emergencyContact',)->default(false); // Teléfono de respaldo (opcional)
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phones');
    }
};
