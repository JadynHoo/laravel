<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //方法已过去了model下要调用就不能直接：：了因为声明的是public不是静态的所以先实例化
        $category = (new Category())->tree();
        //dd($category);
        return view('admin.category.list')->with('data', $category);
    }

    //AJAX路由方法用于异步修改排序
    public function changeOrder()
    {
        $input = Input::all();
            //var_dump($input['cate_id']);
            //var_dump($input['cate_order']);
        $cate = Category::find($input['cate_id']);
        //dd($cate);
        $cate->cate_order = $input['cate_order'];
        $res = $cate->update();
        //echo $res;
        if($res){
            $data = [
                'status'=>1,
                'msg'=>'分类排序更新成功！',
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'分类排序更新失败！，稍后重试',
            ];
        }
        return $data;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //显示添加分类的页面
        $data = Category::where('cate_pid', 0)->get();
        //dd($data);
        return view('admin/category/add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //分类的添加操作
            //dd($input);
        if(session('user')->ability('admin', 'create_category')){
            $input = Input::except('_token');
            $rules =[
                'cate_name'=>'required',
            ];
            $message=[
                'cate_name.required'=>'分类不能为空',
            ];

            $validator = Validator::make($input, $rules, $message);
            if($validator->passes()){
                $re = Category::create($input);
                if($re){
                    return redirect('admin/category');
                }else{
                    return back()->with('errors','数据填充失败，请稍后重试！');
                }
            }else{
                return back()->withErrors($validator);
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
        //分类的修改
        $file = Category::find($id);
        $data = Category::where('cate_pid', 0)->get();
        //dd($data);
        return view('admin/category/edit', compact('file', 'data'));
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
        if(session('user')->ability('admin', 'edit_category')){
            //修改操作
            //dd(Input::all());
            $input = Input::except('_token', '_method');
            //dd($input);
            $res = Category::where('cate_id', $id)->update($input);
            //dd($res);
            if($res){
                return redirect('admin/category');
            }else{
                return back()->with('errors','修改分类失败，请稍后重试！');
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

        if(session('user')->ability('admin', 'delete_category')){
            //删除操作
            //判断分类是否有文章有就不给删除
            $field = Category::Join('article','article.cate_id','=','category.cate_id')->where('category.cate_id',$id)->first();
            //dd(isset($field));
            if(isset($field)){
                $data = [
                    'status'=>1,
                    'msg'=>'该分类下有文章，请先删除文章！',
                ];
                return $data;
            }else{
                $res = Category::where('cate_id', $id)->delete();
                Category::where('cate_pid', $id)->update(['cate_pid'=>0]);
                //dd($res);
                if($res){
                    $data = [
                        'status'=>0,
                        'msg'=>'分类删除成功！',
                    ];
                }else{
                    $data = [
                        'status'=>1,
                        'msg'=>'分类删除失败！',
                    ];
                }

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
