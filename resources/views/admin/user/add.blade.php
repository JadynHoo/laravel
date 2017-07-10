@extends('layouts.admin')
@section('content')


    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a>  &raquo; 添加用户
    </div>
    <!--面包屑导航 结束-->
    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>用户添加</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/users/create')}}"><i class="fa fa-plus"></i>添加用户</a>
                <a href="{{url('admin/users')}}"><i class="fa fa-recycle"></i>用户列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/users')}}" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <table class="add_tab">
                <tbody>

                <tr>
                    <th>用户名称：</th>
                    <td>
                        <input type="text" name="user_name" value="{{old('user_name')}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>这里是默认长度</span>
                    </td>
                </tr>

                <tr>
                    <th>用户密码：</th>
                    <td>
                        <input type="password" name="user_pass" value="{{old('user_name')}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>这里是默认长度</span>
                    </td>
                </tr>



                <tr>
                    <th>角色选择：</th>
                    <td>
                        @foreach($roles as $role)
                            <label for=""><input type="checkbox" name="role[]" value="{{$role->id}}" >{{$role->display_name}}</label>
                        @endforeach
                    </td>
                </tr>



                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>

                </tbody>
            </table>
        </form>
    </div>


@endsection