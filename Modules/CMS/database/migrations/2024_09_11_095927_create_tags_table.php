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
        Schema::create('tags', function (Blueprint $table) {
            $table->id()->comment('Primary key of the categories table');
            $table->string('name', 50)
                  ->unique()
                  ->comment('Name of the category, must be unique and up to 50 characters');
            $table->string('slug', 255)
                  ->unique()
                  ->comment('URL-friendly version of the category name, must be unique and up to 255 characters');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
