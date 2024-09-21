<?php

namespace Modules\User\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

//use Modules\Mag\Database\Factories\API/V1/RoleFactory;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['role_name','description'];

    // protected static function newFactory(): API/V1/RoleFactory
    // {
    //     //return API/V1/RoleFactory::new();
    // }
    public function permissions(){
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
    public function roleId(){
        return $this->hasOne(Permission::class,'role_id');
    }


}
