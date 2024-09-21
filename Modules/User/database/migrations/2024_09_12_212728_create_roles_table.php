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
        Schema::create('roles', function (Blueprint $table) {
            $table->id()
            ->comment('Unique');


            $table->string('role_name', 60)
                  ->unique()
                  ->index()
                  ->comment('Unique name of the role');

            $table->string('description', 255)
                  ->nullable()
                  ->comment('Description of the role');

            $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
