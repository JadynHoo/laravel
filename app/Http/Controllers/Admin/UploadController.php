<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UploadController extends Controller
{
    //
    public function upload()
    {
        //一开始文件上传了是一丢html代码要看就新建一个html文件就能看到文件的信息是数组，但是我们只要Filedata这个数组的值
        //用下面方法能获取
        $file = Input::file('Filedata');
        if($file -> isValid()){
            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file -> move(public_path().'/uploads',$newName);//文件移动的位置
            //return $path;
            $filepath = 'uploads/'.$newName;
            return $filepath;
        }
    }
}
