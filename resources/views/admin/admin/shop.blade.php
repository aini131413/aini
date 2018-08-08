@extends("layouts.admin.default")

@section("title","商铺列表")

@section("content")
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>id</th>
            <th>店铺分类</th>
            <th>名称</th>
            <th>店铺图片</th>
            <th>评分</th>
            <th>是否品牌</th>
            <th>是否准时送达</th>
            <th>是否蜂鸟配送</th>
            <th>是否保标记</th>
            <th>是否票标记</th>
            <th>是否准标记</th>
            <th>起送金额</th>
            <th>配送费</th>
            <th>店公告</th>
            <th>优惠信息</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        @foreach($shops as $shop)
        <tr>
            <td>{{$shop->id}}</td>
            <td>{{$shop->category->name}}</td>
            <td>{{$shop->shop_name}}</td>
            <td>
                @if($shop->shop_img)
                    <img src="{{$shop->shop_img}}" width="80px" height="80px">
                    @else
                    <img src="/gangtiexia.jpg" width="60px" height="100px">
                    @endif
            </td>
            <td>{{$shop->shop_rating}}</td>
            <td>
                @if($shop->brand==0)
                否
                @else
                是
                @endif
            </td>
            <td>
                @if($shop->on_time==0)
                    否
                @else
                    是
                @endif
            </td>
            <td>
                @if($shop->fengniao==0)
                    否
                @else
                    是
                @endif
            </td>

            <td>
                @if($shop->bao==0)
                    否
                @else
                    是
                @endif </td>
            <td>
                @if($shop->piao==0)
                    否
                @else
                    是
                @endif
            </td>
            <td>
                @if($shop->zhun==0)
                    否
                @else
                    是
                @endif
            </td>
            <td>
                {{$shop->start_send}}
            </td>
            <td>
                {{$shop->send_cost}}

            </td>
            <td>
                {{$shop->notice}}

            </td>
            <td>
                {{$shop->discount}}

            </td>
            <td>
                @if($shop->status==0)
                待审
                    <form action="{{route("admin.shop_status",$shop->id)}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="status" value="1">
                        <input type="submit" class="btn btn-success" value="正常">
                    </form>
                    <form action="{{route("admin.shop_status",$shop->id)}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="status" value="-1">
                        <input type="submit" class="btn btn-danger" value="禁用">
                    </form>

                @elseif($shop->status==1)
                正常
                    <form action="{{route("admin.shop_status",$shop->id)}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="status" value="0">
                        <input type="submit" class="btn btn-warning" value="待审">
                    </form>
                    <form action="{{route("admin.shop_status",$shop->id)}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="status" value="-1">
                        <input type="submit" class="btn btn-danger" value="禁用">
                    </form>
                @elseif($shop->status==-1)
                禁用
                    <form action="{{route("admin.shop_status",$shop->id)}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="status" value="0">
                        <input type="submit" class="btn btn-warning" value="待审">
                    </form>
                    <form action="{{route("admin.shop_status",$shop->id)}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="status" value="1">
                        <input type="submit" class="btn btn-success" value="正常">
                    </form>
                @endif
            </td>
            <td>
                <a class="btn btn-success" href="{{route("admin.shop_edit",$shop->id)}}" role="button">编辑</a>
                <a class="btn btn-danger" href="{{route("admin.shop_del",$shop->id)}}" role="button">删除</a>

            </td>
        </tr>


@endforeach

    </table>

    {{--{{$cates->links()}}--}}
    {{$shops->links()}}

@stop