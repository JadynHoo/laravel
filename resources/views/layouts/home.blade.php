<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    @yield('info')
    <link href="{{asset('homestyle/css/base.css')}}" rel="stylesheet">
    <link href="{{asset('homestyle/css/index.css')}}" rel="stylesheet">
    <link href="{{asset('homestyle/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('homestyle/css/new.css')}}" rel="stylesheet">


    <!--[if lt IE 9]>
    <script src="{{asset('homestyle/js/modernizr.js')}}"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="{{url('/')}}"></a></div>
    <nav class="topnav" id="topnav">
       @foreach($navs as $v)<a href="{{$v->nav_url}}"><span>{{$v->nav_name}}</span><span class="en">{{$v->nav_alias}}</span></a>@endforeach
    </nav>
    </nav>
</header>

@section('content')

    <h3>
        <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        @foreach($new as $v)
            <li><a href="{{url('a/'.$v->art_id)}}" title="{{$v->art_title}}" target="_blank">{{$v->art_title}}</a></li>
        @endforeach
    </ul>
    <h3 class="ph">
        <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        @foreach($hotright as $v)
            <li><a href="{{url('a/'.$v->art_id)}}" title="{{$v->art_title}}" target="_blank">{{$v->art_title}}</a></li>
        @endforeach
    </ul>

    @show

<footer>
    <p>{!! Config::get('web.copyright') !!} {!! Config::get('web.web_counts') !!} </p>
</footer>
<script src="{{url('homestyle/js/silder.js')}}"></script>
</body>
</html>
