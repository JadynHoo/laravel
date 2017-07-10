<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Session;

class LoginController extends Controller
{
    //后台界面登录方法加验证
    public function login()
    {
        //return view('admin.login');
        //判断是不是post提交不是着输出面板，是则验证
       // dd(11);
        if($input = Input::all()){
            //dd($input);
            if($input['code'] != session('milkcaptcha')){
                return back()->with('error', '验证码错误');
            }
            //$input = Input::all();
            //dd($input);
            $user = User::where('user_name', $input['user_name'])->first();
            //dd($user);
            //dd($user->user_name);
            if(isset($user)){

                if($user->user_name != $input['user_name'] || Crypt::decrypt($user->user_pass) != $input['user_pass']){
                    return back()->with('error', '账号或者密码错误');
                }

                //成功后将用户信息存进去session里面
                session(['user'=>$user]);
                //echo "111111111";
                //dd(session('user'));
                //echo "ok";
                return redirect('admin/index');
            }else{
                return back()->with('error', '用户不存在');
            }



        }else{
            //session(['user'=>null]);
            return view('admin/login');
        }
    }


    //验证码的显示的方法
    public function code()
    {
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();

        //把内容存入session
        Session::flash('milkcaptcha', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }


    public function crypt()
    {
        $str = Crypt::encrypt('123456');
        echo $str;

//        eyJpdiI6ImVTV3N5UVh2Wkt4eTBJM0E5dVVaaWc9PSIsInZhbHVlIjoiWHRDQ0ZsVVFRaFFoTHlHaW1oa0hPZz09IiwibWFjIjoiODU1ZDkzZGQyMDYxYzNjNWFlMzI5OTY3ZGU5NGIxZWVlNGViYTRmYTZhOWRlZmY1ODU1NzczYWU4OGVjNWRjNiJ9


    }





















   /* //验证登录信息，以及验证码的验证
    public function dologin(Request $request)
    {
        //return $request->all();
        //验证验证码是否相等
        dd(session('milkcaptcha'));
        if($request->input('code') != session('milkcaptcha')){

            return back()->with('error', '验证码错误');

        }

    }*/

}
