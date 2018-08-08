@extends("layouts.admin.default")

@section("title","管理员列表")

@section("content")
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>会员id</th>
            <th>姓名</th>
            <th>电话</th>
            <th>加入时间</th>
            <th>账户余额</th>
            <th>账户积分</th>
            <th>状态</th>

            <th>操作</th>
        </tr>
        @foreach( $vips as $vip)
            <tr>
                <td>{{$vip->id}}</td>
                <td>{{$vip->username}}</td>
                <td>{{$vip->tel}}</td>
                <td>{{$vip->created_at}}</td>
                <td>{{$vip->money}}</td>
                <td>{{$vip->jifen}}</td>
                <td>{{$vip->vip_status}}</td>
                <td>
                    <a class="btn btn-success" href="{{route("vip.status",$vip->id)}}" role="button">禁用||启用</a>
                    <a class="btn btn-danger" href="{{route("vip.money",$vip->id)}}" role="button">充值</a>
                </td>
            </tr>
        @endforeach
    </table>

    {{$vips->links()}}


@stop