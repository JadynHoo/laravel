@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 权限管理
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_title">
                <h3>文章列表</h3>
            </div>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/roles/create')}}"><i class="fa fa-plus"></i>添加角色</a>
                    <a href="{{url('admin/roles')}}"><i class="fa fa-recycle"></i>全部角色</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>角色</th>
                        <th>权限</th>
                        <th>操作</th>
                    </tr>
                        @foreach($roles as $role)
                        <tr>
                            <td class="tc">{{$role->id}}</td>
                            <td>
                                <a href="#">{{$role->display_name or $role->name}}</a>
                            </td>
                            {{--角色对应的权限输出--}}
                            <td>
                                @foreach($role->perms as $perm)
                                    <span>{{$perm->display_name or $perm->name}}</span>
                                @endforeach
                            </td>
                            <td>
                                @if(session('user'))
                                    @if (session('user')->ability('admin', 'edit_role'))
                                <a href="{{url('admin/roles/'.$role->id.'/edit')}}">修改</a>
                                        @endif
                                @endif
                                <a href="javascript:;" onclick="delArt({{$role->id}})" >删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div class="page_list">

                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

    <style>
        .result_content ul li span {
            font-size: 15px;
            padding: 6px 12px;
        }
    </style>

    <script>
        //删除分类
        function delArt(id) {
            layer.confirm('您确定要删除这个角色吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/roles/')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                    if(data.status==0){
                        location.href = location.href;
                        layer.msg(data.msg, {icon: 6});
                    }else{
                        layer.msg(data.msg, {icon: 5});
                    }
                });
//            layer.msg('的确很重要', {icon: 1});
            }, function(){

            });
        }
    </script>

@endsection
