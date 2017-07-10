<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //全部文章列表

        $data = Article::orderBy('art_id','desc')->paginate(5);
        return view('admin.article.index',compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = (new Category())->tree();
        return view('admin/article/add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if(session('user')->ability('admin', 'create_article')){
            $input = Input::except('_token');
            //dd($input);
            $input['art_time'] = time();
            $input['art_view']  = 0;
            $rules = [
                'art_title'=>'required|max:30',
                'art_content'=>'required',
                'art_thumb'=>'required',
                'cate_id'=>'category',
                'art_editor'=>'chinese|required',
            ];

            $message = [
                'art_title.required'=>'文章名称不能为空！',
                'art_title.max'=>'文章名称不能超过30个字！',
                'art_content.required'=>'文章内容不能为空！',
                'art_thumb.required'=>'请上传文件',
                'cate_id.category'=>'请选择分类',
                'art_editor.chinese'=>'作者只能为中文',
                'art_editor.required'=>'作者不能为空',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $re = Article::create($input);
                if($re){
                    return redirect('admin/article');

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
        //文章的修改
        $data = (new Category())->tree();
        //dd(Article::find($id));
        $field = Article::find($id);
        return view('admin/article/edit', compact('data', 'field'));
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
        if(session('user')->ability('admin', 'edit_article')){
            $input = Input::except('_token','_method');
            $re = Article::where('art_id',$id)->update($input);
            if($re){
                return redirect('admin/article');
            }else{
                return back()->with('errors','文章更新失败，请稍后重试！');
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
        //
        if(session('user')->ability('admin', 'delete_article')){
            $info = Article::where('art_id',$id)->first();
            //dd($info->art_thumb);
            $res = unlink($info->art_thumb);
            $re = Article::where('art_id',$id)->delete();
            if($re&&$res){
                $data = [
                    'status' => 0,
                    'msg' => '文章删除成功！',
                ];
            }else{
                $data = [
                    'status' => 1,
                    'msg' => '文章删除失败，请稍后重试！',
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
