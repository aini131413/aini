@extends("layouts.admin.default")

@section("title","活动列表")

@section("content")
    <form method="post" action="" enctype="multipart/form-data" >
        {{csrf_field()}}
        <div class="form-group" style="margin-top: 30px">
            <label for="title">活动标题</label>
            <input type="text" class="form-control" id="title" placeholder="活动标题" name="title">
        </div>
        <div class="form-group">
            <label for="start_time">开始时间</label>
            <input type="date" class="form-control" id="start_time" placeholder="开始时间" name="start_time">
        </div>
        <div class="form-group">
            <label for="end_tiem">结束时间</label>
            <input type="date" class="form-control" id="end_tiem" placeholder="结束时间" name="end_time">
        </div>
        <div class="form-group">
            <label for="container">活动详情</label>
            <!-- 实例化编辑器 -->
            <script type="text/javascript">
                var ue = UE.getEditor('container');
                ue.ready(function() {
                    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.

                });
            </script>

            <!-- 编辑器容器 -->
            <script id="container"  name="content" type="text/plain"></script>
        </div>

        <div class="form-group">
            <input type="submit" class="form-control" value="提交">
        </div>
</form>


@stop