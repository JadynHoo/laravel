@extends('layouts.home')
@section('info')
  <title>{{Config::get('web.web_title')}}</title>
  <meta name="keywords" content="{{Config::get('web.keywords')}}" />
  <meta name="description" content="{{Config::get('web.description')}}" />
  @endsection
@section('content')

<div class="banner">
  <section class="box">
    <ul class="texts">
      <p>打了死结的青春，捆死一颗苍白绝望的灵魂。</p>
      <p>为自己掘一个坟墓来葬心，红尘一梦，不再追寻。</p>
      <p>加了锁的青春，不会再因谁而推开心门。</p>
    </ul>
    <div class="avatar"><a href="#"><span>Jadynhoo</span></a> </div>
  </section>
</div>
<div class="template">
  <div class="box">
    <h3>
      <p><span>热文</span>推荐 Rcommend</p>
    </h3>
    <ul>
      @foreach($hot as $v)
      <li><a href="{{url('a/'.$v->art_id)}}"  target="_blank"><img src="{{url($v->art_thumb)}}"></a><span>{{$v->art_title}}</span></li>
      @endforeach
    </ul>
  </div>
</div>
<article>
  <h2 class="title_tj">
    <p>文章<span>推荐</span></p>
  </h2>
  <div class="bloglist left">
    @foreach($data as $v)
    <h3>{{$v->art_title}}</h3>
    <figure><img src="{{url($v->art_thumb)}}"></figure>
    <ul>
      <p>{{$v->art_description}}</p>
      <a title="{{url('a/'.$v->art_title)}}" href="{{url('a/'.$v->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <p class="dateview"> <span>{{date('Y-m-d', $v->art_time)}}</span><span>作者：{{$v->art_editor}}</span><span>个人博客：[<a href="javascript:;">Jadynhoo</a>]</span></p>
@endforeach
    {{--ajax流加载--}}
    <div class="page" id="lists">
      <h2 class="tip">提示：使用滚动或拉动滚动条向下看。</h2>
      <div class="nodata"></div>
    </div>
  </div>
  <aside class="right">
    <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
    <script type="text/javascript" id="bdshell_js"></script>
    <script type="text/javascript">
//        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
    </script>
    <!-- Baidu Button END -->
    <div class="news" style="float: left">
     @parent
    <h3 class="links">
      <p>友情<span>链接</span></p>
    </h3>
    <ul class="website">
     @foreach($link as $v)
      <li><a href="{{url($v->link_url)}}" target="_blank">{{$v->link_name}}</a></li>
       @endforeach
    </ul> 
    </div>  

    </aside>
</article>
<script type="text/javascript" src="{{asset('homestyle/js/jquery-1.10.2.min.js')}}"></script>
<script>
    var index = 1;
    var totalpage = 6; //总页数，防止超过总页数继续滚动
    var winH = $(window).height(); //页面可视区域高度
    $(window).scroll(function() {

        if (index < totalpage) { // 当滚动的页数小于总页数的时候，继续加载

            var pageH = $(document.body).height();
            var scrollT = $(document).scrollTop(); //滚动条top
            var rate = (pageH - winH - scrollT) / winH;
            if (rate < 0.01) {
                $(".nodata").show().html("<img src='http://www.sucaihuo.com/Public/images/loading.gif'/>");
                $.getJSON("{{url('/ajax')}}", { page: index}, function(json) {
                    if (json) {
                        console.log(JSON.stringify(json));
                        var str = "";
                        $.each(json,
                            function(index, array) {
                                //console.log(array['art_id']);
                                //alert(document.location.href);
                                var url = document.location.href;
                                var publish_at = new Date(array['art_time']*1000).toLocaleDateString();
                                var str = '';
                                var str =  "<h3>"+array['art_title']+"</h3>"+"<figure><img src="+array['art_thumb']+"></figure>"+"<ul>"+
                                    "<p>"+array['art_description']+"</p>"+
                                    '<a href="'+url+'a/'+array['art_id']+'" target="_blank" class="readmore">阅读全文>></a>'+
                                    "</ul>"+"<p class='dateview'>"+"<span>"+publish_at+"</span>"+"<span>作者："+array['art_editor']+"</span>"+"<span>个人博客：["+"<a href='javascript:;'>Jadynhoo</a>]</span></p>";
                                $("#lists").before(str);
                            });
                        $(".nodata").hide()
                    } else {
                        showEmpty(); //数据为空的时候
                    }
                });
                index++;
            }
        } else { //否则显示无数据
            showEmpty();
        }
    });
//console.log(new Date(1499175085000).toLocaleDateString());
    function getJson(index) {

    }
    function showEmpty() {
        $(".nodata").show().html("别滚动了，已经到底了。。。");
    }



</script>

@endsection
