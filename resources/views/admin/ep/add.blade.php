@extends("layouts.admin.default")

@section("title","添加奖品")

@section("content")

    <div class="container" style="margin-top: 30px">

        <form action="" class="form-group" method="post">
            {{--用户名--}}
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <label for="username">奖品名称</label>
                <div class="input-group">
                    <span class="input-group-addon"></span>
                    <input name="name" class="form-control" placeholder="请输入奖品名称" maxlength="20" type="text" value="{{old("name")}}">
                </div>
            </div>

           {{--所属活动--}}
            <div class="form-group has-feedback"
            >
                <label >所属活动</label>
                <div class="input-group">
                    <span class="input-group-addon"></span>
         <select name="event_id" >
                        @foreach($events as $event)
          <option value="{{$event->id}}" class="form-control">{{$event->title}}</option>
                        @endforeach

          </select>

                </div>
            </div>


            {{--奖品描述--}}
            <div class="form-group has-feedback">
                <label for="password">奖品描述</label>
                <div class="input-group">
                    <script type="text/javascript">
                        var ue = UE.getEditor('container');
                        ue.ready(function() {
                            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
                        });
                    </script>

                    <!-- 编辑器容器 -->
                    <script id="container" name="description" type="text/plain">{!! old("description") !!}</script>

                </div>
            </div>




                <input class="form-control btn btn-primary" id="submit" value="立&nbsp;&nbsp;即&nbsp;&nbsp;添&nbsp;&nbsp;加" type="submit">


            <div class="form-group">
                <input value="重置" id="reset" class="form-control btn btn-danger" type="reset">
            </div>
        </form>

    </div>


@stop