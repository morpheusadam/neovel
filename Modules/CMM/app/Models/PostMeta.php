<?php

namespace Modules\CMM\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostMeta extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'post_meta'; // Specify the table name

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
