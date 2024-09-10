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
        Schema::create('user_meta', function (Blueprint $table) {
            $table->id()->comment('Primary key');
            $table->unsignedBigInteger('user_id')->comment('Foreign key referencing users table');
            $table->string('meta_key')->index()->comment('Key for the meta data');
            $table->text('meta_value')->nullable()->comment('Value for the meta data');

            $table->unique(['user_id', 'meta_key'], 'user_meta_unique');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade')
                  ->comment('Foreign key constraint for user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_meta');
    }
};
