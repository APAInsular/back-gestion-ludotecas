<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bonus_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playroom_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->integer('minutes');
            $table->decimal('price', 8, 2);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bonus_products');
    }
};
