<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->comment('Foreign key referencing users table');
            $table->unsignedBigInteger('role_id')->comment('Foreign key referencing roles table');

            $table->primary(['user_id', 'role_id']);

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade')
                  ->comment('Foreign key constraint for user_id');

            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('cascade')
                  ->onUpdate('cascade')
                  ->comment('Foreign key constraint for role_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
