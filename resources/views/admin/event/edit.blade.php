@extends("layouts.admin.default")

@section("title","编辑抽奖活动")

@section("content")
    <form class="form-horizontal" action="" method="post" style="margin-top: 30px">
        {{csrf_field()}}
        <div class="form-group">
            <label class="col-sm-2 control-label">标题</label>
            <div class="col-sm-10">
                <input type="text" name="title" class="form-control" value="{{old("title",$event->title)}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">报名开始时间</label>
            <div class="col-sm-10">
                <input type="datetime-local" name="start_time" value="{{$event->start_time}}" >
            </div>
            <label class="col-sm-2 control-label">报名结束时间</label>
            <div class="col-sm-10">
            <input type="datetime-local" name="end_time" value="{{old("end_time",$event->end_time)}}" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">开奖时间</label>
            <div class="col-sm-10">
                <input type="datetime-local" name="prize_time" value="{{old("prize_time",$event->prize_time)}}" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">人数限制</label>
            <div class="col-sm-10">
                <input type="text" name="num" class="form-control" value="{{old("num",$event->num)}}" >
                <input type="hidden" name="is_prize" class="form-control" value=0 >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">内容</label>
            <div class="col-sm-10">
                <script type="text/javascript">
                    var ue = UE.getEditor('container');
                    ue.ready(function() {
                        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
                    });
                </script>

                <!-- 编辑器容器 -->
                <script id="container" name="content" type="text/plain">{!!$event->content !!}</script>


            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">提交</button>
            </div>
        </div>
    </form>

@stop