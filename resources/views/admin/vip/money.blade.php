@extends("layouts.admin.default")

@section("title","管理员列表")

@section("content")

    <form class="form-group" method="post" action="" style="margin-top: 100px">
        {{csrf_field()}}
        <h2 class="form-group-lg" align="center" for="exampleInputAmount">即将为：{{$vip->username}}充值</h2>
        <div class="form-group" style="margin-top: 50px">

            <div class="input-group">
                <div class="input-group-addon">$</div>
                <input type="text" class="form-control" id="exampleInputAmount" placeholder="Amount" name="money">
                <div class="input-group-addon">.00</div>
            </div>
        </div>
        <button type="submit" style="font-size: 20px"  class="btn btn-info form-control">确认充值</button>
    </form>

@stop