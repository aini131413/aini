@extends("layouts.shop.default")

@section("title","订单详情")

@section("content")
    <h2 style="margin: 30px;" align="center">日报表</h2>
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
            <th>订单数量</th>
            <th>订单总金额</th>
        </tr>
        @foreach( $datas as $data)
        <tr>
            <td>{{$data->date}}</td>
            <td>{{$data->count}}</td>
            <td>{{$data->money}}</td>
        </tr>
        @endforeach

    </table>

    <h2 style="margin: 30px" align="center">月报表</h2>

    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>月份</th>
            <th>订单数量</th>
            <th>订单总金额</th>
        </tr>
        @foreach( $ms as $m)
            <tr>
                <td>{{$m->month}}</td>
                <td>{{$m->jilu}}</td>
                <td>{{$m->mon}}</td>
            </tr>
        @endforeach

    </table>


@stop