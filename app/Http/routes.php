<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//前台首页路由
Route::get('/', 'Home\IndexController@index');

//前台列表页
Route::get('/cate/{cate_id}', 'Home\IndexController@cate');

//前台文章页
Route::get('/art', 'Home\IndexController@article');

//前台文章
Route::get('/a/{art_id}', 'Home\IndexController@article');


//后台登录界面加登录验证升级版
Route::any('/admin/login', 'Admin\LoginController@login');

//验证码登录路由
Route::get('/admin/code', 'Admin\LoginController@code');

//Ajax流加载
Route::any('/ajax', 'Home\AjaxController@ajax');

//中间键还可以把相同的命名空间和前缀写上去
Route::group(['middleware' => ['admin.login'], 'prefix'=>'admin', 'namespace'=>'Admin'], function () {

    //后台登录界面首页
    Route::get('index', 'IndexController@index');

    //index文件的右边栏路由
    Route::any('info', 'IndexController@info');

    //quit路由
    Route::get('quit', 'IndexController@quit');

    //修改密码路由
    Route::any('pass', 'IndexController@pass');

    //文章分类使用资源路由比较好
    Route::resource('category', 'CategoryController');

    //ajax异步处理排序的url
    Route::post('cate/changeorder', 'CategoryController@changeOrder');

    //文章管理路由
    Route::resource('article', 'ArticleController');

    //友情链接
    Route::post('links/changeorder', 'LinkController@changeOrder');
    Route::resource('links', 'LinkController');

    //自定义导航了
    Route::post('navs/changeorder', 'NavsController@changeOrder');
    Route::resource('navs', 'NavsController');

    //配置内容
    Route::post('config/changecontent', 'ConfigController@changeContent');
    Route::post('config/changeorder', 'ConfigController@changeOrder');
    Route::resource('config', 'ConfigController');

    //修改配置
    Route::get('config/putfile', 'ConfigController@putFile');

    //文件上传
    Route::any('upload', 'UploadController@upload');

    //权限管理
    Route::resource('roles', 'RolesController');
    Route::resource('premissions', 'PremissionsController');
    Route::resource('users', 'UsersController');

});