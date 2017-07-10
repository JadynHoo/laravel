<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Link;
use App\Http\Model\Nav;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


class IndexController extends CommentController
{
    //显示首页
    public function index()
    {
     /*Redis::set('11','11');
     dd(Redis::get('11'));*/
        //点击量最多的6篇文章（推荐栏）
        $hot = Article::orderBy('art_view', 'desc')->take(6)->get();
        //图文列表和分页
        $data = Article::orderBy('art_time', 'desc')->take(6)->get();
        //dd($data);

        //友情链接
        $link = Link::orderBy('link_order', 'desc')->get();
        //dd($link);
        //配置项SEO优化

        //继承comment里面共享navs到所有页面
        return view('home/index', compact('hot', 'data',  'link'));
    }

    //显示列表页
    public function cate($cate_id)
    {
        $field = Category::find($cate_id);
        //4篇图文列表和分页
        //（做redis缓存）
        //$redisId = Redis::get('contentId');
        //$data = Article::where('cate_id', $cate_id)->orderBy('art_time', 'desc')->paginate(4);
        //dd(json_encode($data));
//        $data = Article::where('cate_id', $cate_id)->orderBy('art_time', 'desc')->paginate(4);
//        Redis::hSet("articlelist:$cate_id",'articlelist', json_encode($data));
//        $data = '';
      /*  if(Redis::exists("articlelist:$cate_id")){
            echo  '查缓存';
            $data = Redis::hGet("articlelist:$cate_id", "articlelist");
            $arr = json_decode($data);
            $data = $arr->data;
//
        }else{*/
            //$contentId = Redis::incr('contentId');
            $data = Article::where('cate_id', $cate_id)->orderBy('art_time', 'desc')->paginate(4);
          /* Redis::hSet("articlelist:$cate_id",'articlelist', json_encode($data));*/

       /* }*/
        //右边的子分类
        $leftcate = Category::where('cate_pid', $cate_id)->get();
        //dd($leftcate);
        //dd($data);
        return view('home/list', compact('field', 'data', 'leftcate'));
    }

    //显示文章页
    public function article($art_id)
    {
        //echo $art_id;
        $field = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();
        //dd($field);
        //上一篇，下一篇
        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
        //查看次数自增
        Article::where('art_id',$art_id)->increment('art_view');
        //相关文章
        if(Redis::exists("article:$art_id")){
            echo '查缓存';
            $data = Redis::hGet("article:$art_id", "article");
            $data = json_decode($data);
            /*$data = $arr->data;*/
        }else{
            $data = Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();
            Redis::hSet("article:$art_id",'article', json_encode($data));
        }

        //dd($data);
        return view('home/new', compact('field', 'article', 'data'));
    }



}
