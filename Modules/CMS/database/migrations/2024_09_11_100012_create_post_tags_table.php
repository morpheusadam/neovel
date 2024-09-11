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
        Schema::create('post_tags', function (Blueprint $table) {
            $table->foreignId('post_id')
            ->constrained('posts')
            ->comment('Foreign key referencing posts table');
      $table->foreignId('tag_id')
            ->constrained('tags')
            ->comment('Foreign key referencing tags table');
      $table->primary(['post_id', 'tag_id'])
            ->comment('Composite primary key consisting of post_id and tag_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tags');
    }
};
