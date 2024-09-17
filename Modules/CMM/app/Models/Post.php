<?php

namespace Modules\CMM\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function meta()
    {
        return $this->hasMany(PostMeta::class);
    }

    public function getThumbnailAttribute()
    {
        return optional($this->meta()->where('meta_key', 'thumbnail')->first())->meta_value;
    }
}
