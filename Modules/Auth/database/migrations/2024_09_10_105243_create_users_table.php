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
        Schema::create('users', function (Blueprint $table) {
            $table->id()
            ->comment('Unique');

        $table->string('username', 50)
              ->unique()
              ->index()
              ->comment('Unique username for the user');

              $table->string('phone', 15)
              ->nullable()
              ->unique() 
              ->comment('phone number');

        $table->string('password', 255)
              ->comment('Hashed password for the user');

        $table->string('email', 100)
              ->unique()
              ->index()
              ->comment('Unique email address for the user');

        $table->boolean('is_active')
              ->default(true)
              ->comment('Indicates if the user is active');

        $table->timestamp('email_verified_at')
              ->nullable()
              ->comment('Timestamp when the user\'s email was verified');

        $table->timestamps();
        $table->softDeletes();

         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
