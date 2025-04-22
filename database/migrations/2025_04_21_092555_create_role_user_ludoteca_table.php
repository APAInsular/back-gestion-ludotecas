<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('role_user_ludoteca', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('playroom_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();

            // PK compuesta
            $table->primary(['user_id','playroom_id','role_id'], 'lur_primary');

            // FKs
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('playroom_id')
                  ->references('id')->on('playrooms')
                  ->onDelete('cascade');

            $table->foreign('role_id')
                  ->references('id')->on('roles')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_user_ludoteca');
    }
};
