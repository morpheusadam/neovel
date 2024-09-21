<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Modules\User\Database\Factories\API/V1/UserRoleFactory;

class UserRole extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'user_roles';

    // protected static function newFactory(): API/V1/UserRoleFactory
    // {
    //     //return API/V1/UserRoleFactory::new();
    // }
}
