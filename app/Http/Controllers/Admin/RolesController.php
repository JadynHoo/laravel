<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Permission;
use App\Http\Model\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //输出角色与权限的关系列表

        $roles = Role::with('prems')->get();
        //dd($roles);
        return view('admin/role/index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //新建角色页面同时可以选择权限
        $perms = Permission::get();
        return view('admin/role/add', compact('perms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //验证规则
        //dd($request->perm);
        if(session('user')->ability('admin', 'create_role')){
            $this->validate($request, [
                'name'=>'required|alpha',
                'display_name'=>'required',
            ],[
                'required' => ':attribute 是必填字段',
                'alpha' => ':attribute 只允许字母',
            ],[
                'name' => '角色名称',
                'display_name' => '角色显示名称',
            ]);

            //添加角色和权限操作
            $role = Role::create([
                'name'=>$request->name,
                'display_name'=>$request->display_name,
                'description'=>$request->description,
            ]);
            if($request->perm){
                $role->attachPermissions($request->perm);
            }
            //判断添加是否成功
            if ($role){
                return redirect('admin/roles');
            }else{
                return back()->withInput();
            }
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
        //角色修改页面
        //dd($id);
        //传递所有权限和对于ID的角色资料
        $roles = Role::with('prems')->find($id);
        $perms = Permission::get();
        return view('admin/role/edit', compact('roles', 'perms'));
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
        if(session('user')->ability('admin', 'edit_role')){
            //验证修改规则
            $this->validate($request, [
                'name'=>'required|alpha',
                'display_name'=>'required',
            ],[
                'required' => ':attribute 是必填字段',
                'alpha' => ':attribute 只允许字母',
            ],[
                'name' => '角色名称',
                'display_name' => '角色显示名称',
            ]);

            //修改角色操作
            $role = Role::find($id);
            $role-> name=$request->name;
            $role->display_name=$request->display_name;
            $role->description=$request->description;
            $role->update();
            $role->savePermissions($request->perm);

            //修改成功判断
            if($role){
                return redirect('admin/roles');
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

        if(session('user')->ability('admin', 'delete_role')){
            //角色删除操作
            $role = Role::where('id',$id)->delete();
            $permission_role = DB::table('permission_role')->where('role_id', $id)->delete();
            if($role){
                $data = [
                    'status' => 0,
                    'msg' => '角色删除成功！',
                ];
            }else{
                $data = [
                    'status' => 1,
                    'msg' => '角色删除失败，请稍后重试！',
                ];
            }
            return $data;
        }else{
            $data = [
                'status' => 1,
                'msg' => '没有删除权限！'
            ];

            return $data;
        }

    }
}
