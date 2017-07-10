<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Permission;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PremissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //权限角色显示
        $premissions = Permission::all();
        return view('admin/premission/index', compact('premissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //添加权限页面
        return view ('admin/premission/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //权限添加操作
        if(session('user')->ability('admin', 'create_prem')){
            //验证规则
            $this->validate($request, [
                'name'=>'required|alpha_dash',
                'display_name'=>'required',
            ],[
                'required' => ':attribute 是必填字段',
                'alpha_dash' => ':attribute 只允许字母下划线数字',
            ],[
                'name' => '权限名称',
                'display_name' => '权限显示名称',
            ]);

            //添加权限
            $premission = Permission::create([
                'name'=>$request->name,
                'display_name'=>$request->display_name,
                'description'=>$request->description,
            ]);
            //判断添加是否成功
            if ($premission){
                return redirect('admin/premissions');
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
        //修改权限页面
        $premissions = Permission::find($id);
        return view('admin/premission/edit', compact('premissions'));
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
        //权限修改操作
        if(session('user')->ability('admin', 'edit_prem')){
            $this->validate($request, [
                'name'=>'required|alpha_dash',
                'display_name'=>'required',
            ],[
                'required' => ':attribute 是必填字段',
                'alpha_dash' => ':attribute 只允许字母下划线数组',
            ],[
                'name' => '权限名称',
                'display_name' => '权限显示名称',
            ]);

            //修改权限操作
            $premission = Permission::find($id);
            $premission-> name=$request->name;
            $premission->display_name=$request->display_name;
            $premission->description=$request->description;
            $premission->update();
            if($premission){
                return redirect('admin/premissions');
            }else{
                return back()->with('errors','修改权限失败，请稍后重试！');
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
        if (session('user')->ability('admin', 'delete_prem')) {
            //删除权限操作
            $perms = Permission::findOrFail($id);
            if ($perms->delete()) {

                $data = [
                    'status' => 0,
                    'msg' => '删除权限成功'
                ];
            } else {
                $data = [
                    'status' => 1,
                    'msg' => '删除权限失败，请稍后再试！'
                ];
            }
            return $data;
        }else{
            $data = [
                'status' => 1,
                'msg' => '没有权限！'
            ];

            return $data;
        }
    }

}
