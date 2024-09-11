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
        Schema::create('posts', function (Blueprint $table) {
            $table->id()->comment('Primary key of the posts table');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->comment('Foreign key referencing users table');
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->comment('Foreign key referencing categories table');
            $table->string('title', 255)
                  ->comment('Title of the post, up to 255 characters');
            $table->string('slug', 255)
                  ->unique()
                  ->comment('URL-friendly version of the post title, must be unique and up to 255 characters');
            $table->text('content')
                  ->comment('Content of the post');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
