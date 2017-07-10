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
                <h3>权限列表</h3>
            </div>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/premission/create')}}"><i class="fa fa-plus"></i>添加权限</a>
                    <a href="{{url('admin/premission')}}"><i class="fa fa-recycle"></i>全部权限</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>权限名</th>
                        <th>权限显示名</th>
                        <th>权限描述</th>
                        <th>操作</th>
                    </tr>
                    @foreach($premissions as $premission)
                        <tr>
                            <td class="tc">{{$premission->id}}</td>
                            <td>
                                <a href="#">{{$premission->name}}</a>
                            </td>
                            <td>{{$premission->display_name}}</td>
                            <td>{{$premission->description}}</td>
                            <td>
                                @if(session('user'))
                                    @if (session('user')->ability('admin', 'edit_prem'))
                                <a href="{{url('admin/premissions/'.$premission->id.'/edit')}}">修改</a>
                                        @endif
                                @endif
                                <a href="javascript:;" onclick="delArt({{$premission->id}})" >删除</a>
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
                $.post("{{url('admin/premissions')}}/"+id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
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
