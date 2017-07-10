@extends('layouts.admin')
@section('content')


    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a>  &raquo; 添加角色
    </div>
    <!--面包屑导航 结束-->
    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>角色添加</h3>
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
                <a href="{{url('admin/roles/create')}}"><i class="fa fa-plus"></i>添加角色</a>
                <a href="{{url('admin/roles')}}"><i class="fa fa-recycle"></i>角色列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/roles/'.$roles->id)}}" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="_method" value="PUT">
            <table class="add_tab">
                <tbody>

                <tr>
                    <th>角色名称：</th>
                    <td>
                        <input type="text" name="name" value="{{$roles->name}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>这里是默认长度</span>
                    </td>
                </tr>

                <tr>
                    <th>角色显示名称：</th>
                    <td>
                        <input type="text" name="display_name" value="{{$roles->display_name}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>这里是默认长度</span>
                    </td>
                </tr>



                <tr>
                    <th><i class="require">*</i>角色描述：</th>
                    <td>
                        <input type="text" class="lg" name="description" size="10" value="{{$roles->description}}"><p>标题可以写30个字</p>
                    </td>
                </tr>



                <tr>
                    <th>权限选择：</th>
                    <td>
                        @foreach($perms as $perm)
                            <label for=""><input type="checkbox" name="perm[]" value="{{$perm->id}}" {{$roles->hasPermission($perm->name)?'checked':''}}>{{$perm->display_name}}</label>
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