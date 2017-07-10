<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class AjaxController extends Controller
{
    //ajax流加载
    public function ajax(Request $request)
    {
        $i = $request->get('page');
        $offest = 6 * $i;
        $hots = Article::orderBy('art_time', 'desc')->offset($offest)->limit(6)->get();
        return Response::json($hots);
    }
}