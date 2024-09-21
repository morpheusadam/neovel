<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
                ->nullable()
                ->index()
                ->comment('Unique username for the user');
            $table->string('name', 50)
                ->comment(' for the user');

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

        DB::table('users')->insert([
            [
                'username' => 'user1',
                'phone' => '1234567890',
                'name' => 'User One',
                'password' => bcrypt('password1'),
                'email' => 'user1@example.com',
                'is_active' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'user2',
                'phone' => '0987654321',
                'name' => 'User Two',
                'password' => bcrypt('password2'),
                'email' => 'user2@example.com',
                'is_active' => true,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more users as needed
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};




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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id()
            ->comment('Unique');


            $table->string('permission_name', 60)
                  ->unique()
                  ->index()
                  ->comment('Unique name of the permission');

            $table->string('description', 255)
                  ->nullable()
                  ->comment('Description of the permission');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};

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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->comment('Foreign key referencing users table');
            $table->unsignedBigInteger('role_id')->comment('Foreign key referencing roles table');

            $table->primary(['user_id', 'role_id']);

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade')
                  ->comment('Foreign key constraint for user_id');

            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('cascade')
                  ->onUpdate('cascade')
                  ->comment('Foreign key constraint for role_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};

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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->comment('Foreign key referencing roles table');
            $table->unsignedBigInteger('permission_id')->comment('Foreign key referencing permissions table');

            $table->primary(['role_id', 'permission_id']);

            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('cascade')
                  ->onUpdate('cascade')
                  ->comment('Foreign key constraint for role_id');

            $table->foreign('permission_id')
                  ->references('id')
                  ->on('permissions')
                  ->onDelete('cascade')
                  ->onUpdate('cascade')
                  ->comment('Foreign key constraint for permission_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};

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

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'phone',
        'name',
        'password',
        'email',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function meta()
    {
        return $this->hasMany(UserMeta::class);
    }
}



php artisan make:model Users/Role
php artisan make:model Users/Permission
php artisan make:model Users/UserRole
php artisan make:model Users/RolePermission
php artisan make:model Users/UserMeta
