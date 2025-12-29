<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bonus_products', function (Blueprint $table) {
            $table->enum('type', ['bonus', 'product'])->default('bonus');
        });
    }

    public function down(): void
    {
        Schema::table('bonus_products', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
