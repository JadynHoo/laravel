<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    //后台界面显示的方法
    public function index()
    {
        return view('admin.index');
    }

    //后台界面右边栏的显示方法
    public function info()
    {
        return view('admin.info');
    }

    //退出登录方法
    public function quit()
    {
        session(['user' => null]);
        return redirect('admin/login');
    }

    //修改密码的方法
    public function pass(Request $request)
    {
        if($input = Input::all()){
            //dd($input);
            $rules =[
                'password'=>'required | between:6,20 | confirmed',
            ];
            $message=[
                'password.required'=>'新密码不能为空',
                'password.between'=>'新密码必须在6-20位之间!',
                'password.confirmed'=>'两次密码输入不一样!',
            ];

            $validator = Validator::make($input, $rules, $message);
            if($validator->passes()){
                //echo 'yes';
                //验证成功后开始替换密码
                $user_id = session('user')->user_id;
                //dd($user_id);
                $user = User::where('user_id', $user_id)->first();
                //dd($user);
                $password = Crypt::decrypt($user->user_pass);
                //dd($password);
                if($input['password_o']==$password){
                    $user->user_pass = Crypt::encrypt($input['password']);
                    return back()->with('errors', '密码修改成功');
                }else{
                    return back()->with('errors','原密码错误！');
                }


            }else{
//               dd( $validator->errors());
               return back()->withErrors($validator);
               // return back()->with('status', 'Profile updated!');
//                return back()->with('ff','fffffff');
            }
        }else{
            return view('admin.pass');

        }
    }


}
