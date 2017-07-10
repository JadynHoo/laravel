<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;
class Role extends EntrustRole
{
    //角色与权限模型关联输出权限
    protected $guarded=[];
    public function prems()
    {
        return $this->belongsTo('App\Http\Model\Permission');
    }
}
