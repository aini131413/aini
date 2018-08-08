@extends("layouts.admin.default")

@section("title","订单管理")

@section("content")
    {{--每日订单统计--}}
    <h2 align="center" style="margin-top: 30px">每日订单统计</h2>
    <form class="form-inline" action="" method="get" >
        <div class="form-group">
            <label for="exampleInputName2">开始日期</label>
            <input type="date" class="form-control" id="exampleInputName2" value="{{request()->start}}" name="start">
        </div>----
        <div class="form-group">
            <label for="exampleInputEmail2">结束日期</label>
            <input type="date" class="form-control" id="exampleInputEmail2" value="{{request()->end}}" name="end">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail3">商家列表</label>
            <select name="user" id="exampleInputEmail3">
                <option value="">请选择</option>
                @foreach($users as $user)
                <option value="{{$user->shop_id}}"
                        @if(request()->user==$user->shop_id)
                        selected
                        @endif
                >{{$user->name}}</option>
                @endforeach


            </select>
        </div>
        <button type="submit" class="btn btn-success">查询</button>
    </form>
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>日期</th>
            <th>店铺名称</th>
            <th>订单数量</th>
            <th>订单总金额</th>
        </tr>
        @foreach( $orders as $order)
            <tr>
                <td>{{$order->date}}</td>
                <td>{{$order->shop->shop_name}}</td>
                <td>{{$order->count}}</td>
                <td>{{$order->money}}</td>
            </tr>
        @endforeach

    </table>
    {{--每日订单统计结束--}}


    {{--每月订单统计开始--}}

    <h2 align="center" style="margin-top: 30px">每月订单统计</h2>
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>月份</th>
            <th>店铺名称</th>
            <th>订单数量</th>
            <th>订单总金额</th>
        </tr>
        @foreach( $os as $o)
            <tr>
                <td>{{$o->d}}</td>
                <td>{{$o->shop->shop_name}}</td>
                <td>{{$o->c}}</td>
                <td>{{$o->m}}</td>
            </tr>
        @endforeach

    </table>
    {{--每月订单统计结束--}}

    {{--每日商品销售统计开始--}}

    <h2 align="center" style="margin-top: 30px">每日商品销售统计 </h2>
    <form class="form-inline" action="" method="get" >
        <div class="form-group">
            <label for="exampleInputName2">开始日期</label>
            <input type="date" class="form-control" id="exampleInputName2" value="{{request()->s}}" name="s">
        </div>----
        <div class="form-group">
            <label for="exampleInputEmail2">结束日期</label>
            <input type="date" class="form-control" id="exampleInputEmail2" value="{{request()->e}}" name="e">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail3">商家列表</label>
            <select name="u" id="exampleInputEmail3">
                <option value="">请选择</option>
                @foreach($us as $u)
                    <option value="{{$u->shop_id}}"
                            @if(request()->u==$u->shop_id)
                            selected
                            @endif
                    >{{$u->name}}</option>
                @endforeach


            </select>
        </div>

        <button type="submit" class="btn btn-default">查询</button>
    </form>
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>日期</th>
            <th>商品ID</th>
            <th>商品所属</th>
            <th>商品名称</th>
            <th>数量</th>

        </tr>
        @foreach( $goods as $good)
            <tr>
                <td>{{$good->da}}</td>
                <td>{{$good->goods_id}}</td>
                <td>{{$good->goods_id}}</td>
                <td>{{$good->goods_name}}</td>
                <td>{{$good->nums}}</td>
            </tr>
        @endforeach
    </table>
    {{--每日商品销售统计结束--}}


{{--月商品销售统计--}}
    <h2 align="center" style="margin-top: 30px">月商品销售统计 </h2>

    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>日期</th>
            <th>商品ID</th>
            <th>商品所属</th>
            <th>商品名称</th>
            <th>数量</th>

        </tr>
        @foreach( $gs as $g)
            <tr>
                <td>{{$g->month}}</td>
                <td>{{$g->g_id}}</td>
                <td>{{$g->g_id}}</td>
                <td>{{$g->name}}</td>
                <td>{{$g->num}}</td>
            </tr>
        @endforeach
    </table>
    {{--每日商品销售统计结束--}}


@stop