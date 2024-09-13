<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot
{
    use HasFactory;

    protected $table = 'user_roles';

    protected $guarded = [
        
    ];

    public $timestamps = false; // اضافه کردن این خط
}
