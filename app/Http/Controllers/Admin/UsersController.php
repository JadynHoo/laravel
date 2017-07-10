<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Permission;
use App\Http\Model\Role;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //显示用户的列表页
        /*输出用户角色权限（想输出3个去usermodel解除注释）*/
        /*$users = User::with('roles.perms')->get();*/
        /*输出用户和角色*/
        $users = User::with('roles')->get();
        //dd($users);
        return view('admin/user/index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //添加用户页面
        $roles = Role::all();
        return view('admin/user/add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(session('user')->ability('admin', 'create_admin')){
            //dd(Crypt::encrypt($request->user_pass));
            //验证规则
            //dd($request->user_name);
            $this->validate($request, [
                'user_name'=>'required',
                'user_pass'=>'required',
            ],[
                'required' => ':attribute 是必填字段',
            ],[
                'user_name' => '用户名称',
                'user_pass' => '用户密码',
            ]);
            //添加操作
            $user = User::create([
                'user_name' => $request->user_name,
                'user_pass' => Crypt::encrypt($request->user_pass),//hash加密密码
            ]);
            $roles = $request->role;
            if ($roles) {
                $user->attachRoles($roles);
            }
            return redirect('admin/users');
        }else{
            return back()->with('errors','没有权限，请练习管理员！');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //修改用户信息
        //dd($id);
        $users = User::with('roles')->find($id);
        //dd($users);
        $roles = Role::all();
        return view ('admin/user/edit', compact('users', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //用户修改操作
        //dd(Input::all());
        //验证修改规则
        if(session('user')->ability('admin', 'edit_admin')){
            $this->validate($request, [
                'user_name'=>'required',
                'user_pass'=>'required',
            ],[
                'required' => ':attribute 是必填字段',
            ],[
                'user_name' => '用户名称',
                'user_pass' => '用户密码',
            ]);

            //修改角色操作
            $user = User::find($id);
            //dd($user);
            //dd($request->role);
            $user-> user_name=$request->user_name;
            $user->user_pass=$request->user_pass;
            $user->update();
            /*$user->saveRoles($request->role);*/
            $user->detachRoles();
            $user->attachRoles($request->role);

            //修改成功判断
            if($user){
                return redirect('admin/users');
            }else{
                return back()->with('errors','修改角色失败，请稍后重试！');
            }
        }else{
            return back()->with('errors','没有权限，请练习管理员！');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(session('user')->ability('admin', 'delete_admin')){
            //用户删除操作
            //dd(User::where('user_id',$id)->first());
            $userinfo = User::findOrFail($id);
            //dd($userinfo->user_name);
            if($userinfo->user_name != 'jay'){
                //检查是否为初始管理员时就不给删除
                //dd(1111);
                $user = User::where('user_id',$id)->delete();
                $role_user = DB::table('role_user')->where('user_id', $id)->delete();
                if($user&&$role_user){
                    $data = [
                        'status' => 0,
                        'msg' => '用户删除成功！',
                    ];
                }else{
                    $data = [
                        'status' => 1,
                        'msg' => '用户删除失败，请稍后重试！',
                    ];
                }
                return $data;
            }else{
                $data = [
                    'status' => 1,
                    'msg' => '初始管理员不能删除！'
                ];
                return $data;
            }

        }else{
            $data = [
                'status' => 1,
                'msg' => '没有删除权限！'
            ];

            return $data;
        }

    }

}
