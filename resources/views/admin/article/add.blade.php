@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加文章</h3>
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
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-refresh"></i>全部文章</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/article')}}" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>分类：</th>
                        <td>
                            <select name="cate_id">
                                <option value="0">==文章分类==</option>
                                @foreach($data as $v)
                                <option value="{{$v['cate_id']}}">{{$v['_cate_name']}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>


                    <tr>
                        <th>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="art_title">
                            <p>标题可以写30个字</p>
                        </td>
                    </tr>

                    <tr>
                        <th>作者：</th>
                        <td>
                            <input type="text" class="sm" name="art_editor">

                        </td>
                    </tr>

                    <tr>
                        <th>缩略图：</th>
                        <td>
                            <input type="text" size="50" name="art_thumb">
                            <input id="file_upload" name="file_upload" type="file" multiple="true">
                            <script src="{{asset('/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                            <link rel="stylesheet" type="text/css" href="{{asset('/uploadify/uploadify.css')}}">
                            <script type="text/javascript">
                                <?php $timestamp = time();?>
                                $(function() {
                                    $('#file_upload').uploadify({
                                        'buttonText' : '图片上传',
                                        'formData'     : {
                                            'timestamp' : '<?php echo $timestamp;?>',
                                            '_token'     : "{{csrf_token()}}"
                                        },
                                        'swf'      : "{{asset('/uploadify/uploadify.swf')}}",
                                        'uploader' : "{{asset('admin/upload')}}",
                                        'onUploadSuccess' : function(file, data, response) {
                                            $('input[name=art_thumb]').val(data);
                                            $('#art_thumb_img').attr('src','/'+data);

                                        }
                                    });
                                });
                            </script>
                            <style>
                                .uploadify{display:inline-block;}
                                .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                                table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
                            </style>
                        </td>
                    </tr>

                    <tr>
                        <th></th>
                        <td>
                            <img src="" alt="" id="art_thumb_img" style="max-width: 350px; max-height:100px;">
                        </td>
                    </tr>

                    <tr>
                        <th>关键词：</th>
                        <td>
                            <input type="text" class="lg" name="art_tag">
                        </td>
                    </tr>

                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea class="lg" name="art_description"></textarea>

                        </td>
                    </tr>


                    <tr>
                        <th>文章内容：</th>
                        <td>
                            <script type="text/javascript" charset="utf-8" src="{{url('bianjiqi/ueditor.config.js')}}"></script>
                            <script type="text/javascript" charset="utf-8" src="{{url('bianjiqi/ueditor.all.min.js')}}"> </script>
                            <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
                            <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
                            <script type="text/javascript" charset="utf-8" src="{{url('bianjiqi/lang/zh-cn/zh-cn.js')}}"></script>
                            <script id="editor" type="text/plain" name="art_content" style="width:750px;height:300px;"></script>
                            <script type="text/javascript">
                                var ue = UE.getEditor('editor');
                            </script>
                            <style>
                                .edui-default{line-height: 28px;}
                                div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                                {overflow: hidden; height:20px;}
                                div.edui-box{overflow: hidden; height:22px;}
                            </style>


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