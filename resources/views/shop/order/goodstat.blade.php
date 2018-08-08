@extends("layouts.shop.default")

@section("title","订单详情")

@section("content")
<h2 align="center" style="margin-top: 30px">每日商品销售统计 </h2>
<form class="form-inline" action="" method="get" >
    <div class="form-group">
        <label for="exampleInputName2">开始日期</label>
        <input type="date" class="form-control" id="exampleInputName2" value="{{request()->start}}" name="start">
    </div>----
    <div class="form-group">
        <label for="exampleInputEmail2">结束日期</label>
        <input type="date" class="form-control" id="exampleInputEmail2" value="{{request()->end}}" name="end">
    </div>
    <button type="submit" class="btn btn-default">查询</button>
</form>
    <table class="table table-bordered table-hover" style="text-align: center">
            <tr>
            <th>日期</th>
            <th>商品ID</th>
            <th>商品名称</th>
            <th>数量</th>

             </tr>
        @foreach( $goods as $good)
        <tr>
            <td>{{$good->date}}</td>
            <td>{{$good->goods_id}}</td>
            <td>{{$good->goods_name}}</td>
            <td>{{$good->nums}}</td>
            </tr>
        @endforeach
    </table>
{{--{{$goods->links()}}--}}
<h2 align="center" style="margin-top: 30px">月商品销售统计 </h2>

<table class="table table-bordered table-hover" style="text-align: center">
    <tr>
        <th>日期</th>
        <th>商品ID</th>
        <th>商品名称</th>
        <th>数量</th>

    </tr>
    @foreach( $gs as $g)
        <tr>
            <td>{{$g->month}}</td>
            <td>{{$g->g_id}}</td>
            <td>{{$g->name}}</td>
            <td>{{$g->num}}</td>
        </tr>
    @endforeach
</table>


@stop