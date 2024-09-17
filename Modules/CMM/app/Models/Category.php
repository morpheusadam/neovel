<?php

namespace Modules\CMM\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model
{
    use HasFactory;

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    protected $fillable = ['name', 'parent_id', 'slug', 'description', 'image_path', 'order_column', 'is_visible'];

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Category::where('slug', $model->slug)->exists()) {
                throw new \Exception('The slug must be unique.');
            }
        });

        static::updating(function ($model) {
            if (Category::where('slug', $model->slug)->where('id', '!=', $model->id)->exists()) {
                throw new \Exception('The slug must be unique.');
            }
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
