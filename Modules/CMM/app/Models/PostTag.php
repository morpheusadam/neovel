<?php

namespace Modules\CMM\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostTag extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;
}
