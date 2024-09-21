<?php

namespace Modules\Mag\Models;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model
{
   // use HasFactory, InteractsWithMedia;

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
    ];

    protected $fillable = ['name','image_id', 'parent_id', 'slug', 'description', 'image_path', 'order_column', 'is_visible'];

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
    public function image()
    {
        return $this->belongsTo(Media::class, 'image_id');
    }
}
