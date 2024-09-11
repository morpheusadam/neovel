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
        Schema::create('comments', function (Blueprint $table) {
            $table->id()->comment('Primary key of the comments table');
            $table->foreignId('post_id')
                  ->constrained('posts')
                  ->comment('Foreign key referencing posts table');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->comment('Foreign key referencing users table');
            $table->text('content')
                  ->comment('Content of the comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
