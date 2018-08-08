<!-- header -->
<div class="header">
    <div class="container">
        <nav class="navbar navbar-default">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="logo">
                    <a class="navbar-brand" href="/ele/index.html">Cooks</a>
                </div>
            </div>


            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
                <nav class="cl-effect-13" id="cl-effect-13">
                    <ul class="nav navbar-nav">

                        {{--<li><a href="{{route("admin.login")}}" class="active">管理员登录</a></li>--}}
                        @guest("web")
                            <li><a href="{{route("user.login")}}">商家登录</a></li>
                            <li><a href="{{route("user.add2")}}">商家注册</a></li>
                        @endguest


                        @auth("web")
                            {{--<li><a href="{{route("shop.index")}}">商铺管理</a></li>--}}
                            {{--<li><a href="{{route("user.list")}}">商家管理</a></li>--}}
                  <li><a href="{{route("user.index")}}"> 欢迎您：{{\Illuminate\Support\Facades\Auth::guard("web")->user()->name}} </a></li>
                            <li><a href=""></a></li>
                            <li><a href="{{route("order.index")}}">订单管理</a></li>
                            <li><a href="{{route("order.stat")}}">订单量统计</a></li>
                            <li><a href="{{route("goods.stat")}}">菜品销售统计</a></li>
                            <li><a href="{{route("user.logout")}}">退出登录</a></li>
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