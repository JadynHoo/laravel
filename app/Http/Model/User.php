<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;
class User extends Model
{

    use EntrustUserTrait;
    //user数据库
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $guarded=[];
    public $timestamps = false;



    public function roles()
    {
        return $this->belongsToMany('App\Http\Model\Role', 'role_user',  'user_id', 'role_id')->withPivot(['user_id', 'role_id']);

    }

/*    public function prems()
    {
        return $this->belongsToMany('App\Http\Model\Permission', 'permission_role',  'permission_id', 'role_id')->withPivot(['permission_id', 'role_id']);

    }*/




}
