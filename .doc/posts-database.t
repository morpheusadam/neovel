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
