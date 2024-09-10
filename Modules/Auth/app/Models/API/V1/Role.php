<?php

namespace Modules\Auth\Models\API\V1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Database\Factories\API/V1/RoleFactory;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): API/V1/RoleFactory
    {
        //return API/V1/RoleFactory::new();
    }
}
