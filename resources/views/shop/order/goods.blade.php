@extends("layouts.shop.default")

@section("title","订单详情")

@section("content")

    <table class="table table-bordered table-hover" style="text-align: center">
            <tr>
            <th>id</th>
            <th>订单ID</th>
            <th>商品ID</th>
            <th>数量</th>
            <th>商品名称</th>
            <th>商品单价</th>
            <th>商品图片</th>
             </tr>
        @foreach( $goods as $good)
        <tr>
            <td>{{$good->id}}</td>
            <td>{{$good->order_id}}</td>
            <td>{{$good->goods_id}}</td>
            <td>{{$good->amount}}</td>
            <td>{{$good->goods_name}}</td>
            <td>{{$good->goods_price}}</td>
            <td>
                @if($good->goods_img)
                    <img src="{{$good->goods_img}}" width="80px" height="100px">
                @else
                    该商品暂未添加图片···
               @endif
               </td>
            </tr>
        @endforeach
    </table>




@stop