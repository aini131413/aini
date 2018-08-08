@extends("layouts.shop.default")

@section("title","订单列表")

@section("content")
    {{--<h2 style="margin-top: 20px; ">搜索</h2>--}}
    {{--<form class="form-inline" method="get">--}}
        {{--{{csrf_field()}}--}}
        {{--<div class="form-group">--}}
            {{--<label >菜品分类</label>--}}
            {{--<select name="cate" class="form-control">--}}
                {{--<option value="" >请选择分类</option>--}}
                {{--@foreach($cates as $cate)--}}
                    {{--<option value="{{$cate->id}}" @if(request()->cate==$cate->id)--}}
                        {{--selected--}}
                            {{--@endif--}}
                        {{-->{{$cate->name}}</option>--}}
                {{--@endforeach--}}
            {{--</select>--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<label>菜品名称</label>--}}
            {{--<input type="text" class="form-control"   name="menu" value="{{request()->menu}}">--}}
            {{--</select>--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<label >价格区间</label>--}}
            {{--<input type="number" class="form-control" min="0"  placeholder="0" name="min_price">--}}
            {{--------}}
            {{--<input type="number" class="form-control" min="1"  placeholder="0" name="max_price">--}}
        {{--</div>--}}
        {{--<button type="submit" class="btn btn-default">快速查找</button>--}}
    {{--</form>--}}
    {{--<br>--}}




    <table class="table table-bordered table-hover" style="text-align: center">
            <tr>
            <th>id</th>
            <th>会员名称</th>
            <th>订单编号</th>
            <th>详细地址</th>
            <th>收货电话</th>
            <th>收货人</th>
            <th>总金额</th>
            <th>订单状态</th>
            <th>操作</th>
            </tr>
        @foreach( $orders as $order)
        <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->vip_id}}</td>
            <td>{{$order->sn}}</td>
            <td>{{$order->province.$order->city.$order->county.$order->address}}</td>
            <td>{{$order->tel}}</td>
            <td>{{$order->name}}</td>
            <td>{{$order->total}}</td>
            <td>{{$order->order_status}}</td>
            <td>


                @if($order->status==0)
                    <a class="btn btn-success" href="{{route("order.goods",$order->id)}}" role="button">查看</a>
                    <a class="btn btn-danger" href="{{route("order.cancel",$order->id)}}" role="button">取消</a>
                 @elseif($order->status==1)
                    <a class="btn btn-success" href="{{route("order.goods",$order->id)}}" role="button">查看</a>
                    <a class="btn btn-danger" href="{{route("order.cancel",$order->id)}}" role="button">取消</a>
                <a class="btn btn-danger" href="{{route("order.send",$order->id)}}" role="button">发货</a>
                  @else
                    <a class="btn btn-success" href="{{route("order.goods",$order->id)}}" role="button">查看</a>
                @endif


            </td>
        </tr>
        @endforeach
    </table>


{{$orders->links()}}

@stop