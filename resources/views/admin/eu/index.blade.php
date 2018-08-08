@extends("layouts.admin.default")

@section("title","活动报名列表")

@section("content")


    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th style="text-align: center">活动编号</th>
            <th style="text-align: center">报名商户</th>
        </tr>
        @foreach($eus as $eu)
            <tr>
                <td>{{$eu->event->title}}</td>
                <td>{{$eu->user->name}}</td>
            </tr>
        @endforeach
    </table>



    {{$eus->links()}}


@stop