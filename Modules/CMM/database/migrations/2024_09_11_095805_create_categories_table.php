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
        Schema::create('categories', function (Blueprint $table) {
            $table->id()->comment('Primary key of the categories table');
            $table->string('name', 100)
                  ->unique()
                  ->comment('Name of the category, must be unique');
            $table->text('description')
                  ->nullable()
                  ->comment('Description of the category');
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories')
                  ->comment('Parent category ID, references categories.id');
            $table->string('slug', 255)
                  ->unique()
                  ->comment('URL-friendly version of the category name, must be unique');
            $table->string('image_path')
                  ->nullable()
                  ->comment('Path to the category image');
            $table->boolean('is_visible')
                  ->default(true)
                  ->comment('Visibility of the category');
            $table->integer('order_column')
                  ->default(0)
                  ->comment('Order of the category for display purposes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
