@extends("layouts.admin.default")

@section("title","抽奖活动首页")

@section("content")

    <h2 style="margin-top: 20px; " align="center">抽奖活动</h2>

    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>活动编号</th>
            <th>活动标题</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>开奖时间</th>
            <th>内容</th>
            <th>报名人数/限制人数</th>

            <th>操作</th>
        </tr>
        @foreach($events as $event)
            <tr>
                <td>{{$event->id}}</td>
                <td>{{$event->title}}</td>
                <td>{{$event->start_time}}</td>
                <td>{{$event->end_time}}</td>
                <td>{{$event->prize_time}}</td>
                <td>{!! $event->content !!}</td>
                <td>{{\App\Models\EventUser::where("event_id",$event->id)->count()}}//{{$event->num}}</td>
                <td>
                    @if( $event ->is_prize)
                        <a class="btn btn-warning" href="{{route("prize.index")}}" role="button">已开奖</a>
                    <a class="btn btn-success" href="{{route("event.edit",$event->id)}}" role="button">编辑</a>
                    <a class="btn btn-danger" href="{{route("event.del",$event->id)}}" role="button">删除</a>
                        @else
                        <a class="btn btn-info" href="{{route("event.draw",$event->id)}}" role="button">抽奖</a>
                        <a class="btn btn-success" href="{{route("event.edit",$event->id)}}" role="button">编辑</a>
                        <a class="btn btn-danger" href="{{route("event.del",$event->id)}}" role="button">删除</a>
                        @endif
                </td>
            </tr>
        @endforeach
    </table>

@stop