<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Nav;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    //公共的导航栏，每个页面继承了需要老是nav：：all（）读给一个公共的就不要每一个去找数据库
    public function __construct()
    {
        $navs = Nav::orderBy('nav_order', 'asc')->get();

        //最新文章8篇(右边栏)
        $new = Article::orderBy('art_time', 'desc')->take(8)->get();
        //点击量最多的5篇文章(右边栏)
        $hotright = Article::orderBy('art_view', 'desc')->take(5)->get();

        //把数据共享到每一个页面
        View::share('navs', $navs);
        View::share('new', $new);
        View::share('hotright', $hotright);

    }
}
