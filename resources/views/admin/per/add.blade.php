@extends("layouts.admin.default")

@section("title","添加权限")

@section("content")
    <div class="container" style="margin-top: 30px">

        <form action="" class="form-group" method="post">
            {{--用户名--}}
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <label for="username">添加权限</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    @foreach($us as $u )
  <input name="name[]"  type="checkbox" value="{{$u}}">{{$u}}
                    @endforeach
                </div>
            </div>


            <div class="form-group">

                <input class="form-control btn btn-success" id="submit" value="确&nbsp;&nbsp;认&nbsp;&nbsp;添&nbsp;&nbsp;加" type="submit">
            </div>


        </form>

    </div>



@stop