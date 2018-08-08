@extends("layouts.shop.default")

@section("title","获奖人员列表")

@section("content")


    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th style="text-align: center">奖品ID</th>
            <th style="text-align: center">所属活动</th>
            <th style="text-align: center">奖品名称</th>
            <th style="text-align: center">奖品描述</th>
            <th style="text-align: center">获奖商家</th>
        </tr>
        @foreach($eps as $ep)
       <tr>
          <td>{{$ep->id}}</td>
        <td>{{$ep->event->title}}</td>
        <td>{{$ep->name}}</td>
        <td>{!! $ep->description !!}</td>
        <td>
            @if( $ep -> user_id !==null)
                {{$ep->user->name}}
                @else
            无人中此奖项
                @endif
            </td>

        </tr>
        @endforeach
    </table>






@stop