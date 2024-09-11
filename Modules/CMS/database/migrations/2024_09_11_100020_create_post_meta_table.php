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
        Schema::create('post_meta', function (Blueprint $table) {
            $table->id()->comment('Primary key of the post_meta table');
            $table->foreignId('post_id')
                  ->constrained('posts')
                  ->comment('Foreign key referencing posts table');
            $table->string('meta_key', 50)
                  ->comment('Key for the meta information, up to 50 characters');
            $table->text('meta_value')
                  ->nullable()
                  ->comment('Value for the meta information, can be null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_meta');
    }
};
