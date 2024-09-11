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
        Schema::create('pages', function (Blueprint $table) {
            $table->id()->comment('Primary key of the pages table');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->comment('Foreign key referencing users table');
            $table->string('title', 255)
                  ->comment('Title of the page, up to 255 characters');
            $table->text('content')
                  ->comment('Content of the page');
            $table->string('slug', 255)
                  ->unique()
                  ->comment('URL-friendly version of the page title, must be unique and up to 255 characters');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
