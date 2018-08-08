@extends("layouts.admin.default")

@section("title","活动报名列表")

@section("content")


    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th style="text-align: center">奖品ID</th>
            <th style="text-align: center">所属活动</th>
            <th style="text-align: center">奖品名称</th>
            <th style="text-align: center">奖品描述</th>
            <th style="text-align: center">获奖商家</th>
            <th style="text-align: center">操作</th>
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
           <td>
               <a class="btn btn-success" href="{{route("prize.edit",$ep->id)}}" role="button">编辑</a>
               <a class="btn btn-danger" href="{{route("prize.del",$ep->id)}}" role="button">删除</a>
           </td>
        </tr>
        @endforeach
    </table>



    {{$eps->links()}}


@stop