<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //
    protected $table = 'configs';
    protected $primaryKey = 'conf_id';
    public $timestamps = false;
    protected $guarded=[];
}
