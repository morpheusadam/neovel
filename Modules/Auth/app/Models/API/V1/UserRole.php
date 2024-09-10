<?php

namespace Modules\Auth\Models\API\V1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Database\Factories\API/V1/UserRoleFactory;

class UserRole extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): API/V1/UserRoleFactory
    {
        //return API/V1/UserRoleFactory::new();
    }
}
