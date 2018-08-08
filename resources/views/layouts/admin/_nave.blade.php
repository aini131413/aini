<!-- header -->
<div class="header">
    <div class="container">
        <nav class="navbar navbar-default">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="logo">
                    <a class="navbar-brand" href="#">Cooks</a>
                </div>
            </div>






            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
                <nav class="cl-effect-13" id="cl-effect-13">
                    <ul class="nav navbar-nav">
@guest("admin")
 <li><a href="{{route("admin.login")}}" class="active">管理员登录</a></li>
  @endguest
  @auth("admin")
      {{--循环显示首层导航--}}
        @foreach(\App\Models\Nav::where('pid',0)->get() as $v1)
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$v1->name}} </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route($v1->url)  }}">{{$v1->name}}</a></li>
                    @foreach(\App\Models\Nav::where("pid",$v1->id)->get() as $v2)
                        {{--判断是否有can（）中的权限，--}}
             @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->can($v2->url))
{{--有权限才显示二级导航--}}
               <li><a href="{{ route($v2->url) }}">{{$v2->name}}</a></li>

                        @endif
                    @endforeach
                </ul>
            </li>
        @endforeach
                        <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
               欢迎您{{\Illuminate\Support\Facades\Auth::guard("admin")->user()->name}}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{route("admin.index")}}">管理员列表</a></li>
                                <li><a href="{{route("per.index")}}">权限管理</a></li>
                                <li><a href="{{route("role.index")}}">角色管理</a></li>
                                <li><a href="{{route("admin.logout")}}">退出登录</a></li>
                            </ul>
                        </li>

                        @endauth

                    </ul>
                </nav>
                {{--<div class="social-icons">--}}
                    {{--<ul>--}}
                        {{--<li><a class="icon-link round facebook" href="/"></a></li>--}}
                        {{--<li><a class="icon-link round p" href="/"></a></li>--}}
                        {{--<li><a class="icon-link round twitter" href="/"></a></li>--}}
                        {{--<li><a class="icon-link round dribble" href="/"></a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            </div>
            <!-- /.navbar-collapse -->
        </nav>
    </div>
</div>