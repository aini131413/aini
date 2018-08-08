@extends("layouts.admin.default")

@section("title","管理员编辑")

@section("content")
    <div class="container" style="margin-top: 30px">

        <form action="" class="form-group" method="post">
            {{--用户名--}}
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <label for="username">用户名</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input name="name" class="form-control" placeholder="请输入用户名" maxlength="20" type="text" value="{{old("name",$admin->name)}}">
                </div>
            </div>

            {{--邮箱--}}
            <div class="form-group has-feedback"
                 >
                <label for="email">邮箱</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                    <input name="email" class="form-control" placeholder="请输入邮箱地址" maxlength="20" type="email" value="{{old("email",$admin->email)}}">
                </div>
            </div>


            {{--密码--}}
            <div class="form-group has-feedback">
                <label for="password">密码</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input name="password" class="form-control" placeholder="请输入密码" maxlength="20" type="text" value="123456">
                </div>
            </div>
            {{--确认密码--}}
            {{--<div class="form-group has-feedback">--}}
            {{--<label for="passwordConfirm">确认密码</label>--}}
            {{--<div class="input-group">--}}
            {{--<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>--}}
            {{--<input id="passwordConfirm" class="form-control" placeholder="请再次输入密码" maxlength="20" type="password">--}}
            {{--</div>--}}
            {{--<span style="color:red;display: none;" class="tips"></span>--}}
            {{--<span style="display: none;" class="glyphicon glyphicon-remove form-control-feedback"></span>--}}
            {{--<span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>--}}
            {{--</div>--}}
{{--角色--}}
            <div class="form-group has-feedback">
                <label for="captcha">角色</label>
                    <div class="input-group">
                        <span class="input-group-addon">
              <span class="glyphicon glyphicon-qrcode"></span></span>
                        @foreach($roles as $role )
                        <input type="checkbox" name="role[]" value="{{$role->name}}" >{{$role->name}}
                         @endforeach
                    </div>

            </div>






            <div class="form-group">

                <input class="form-control btn btn-primary" id="submit" value="立&nbsp;&nbsp;即&nbsp;&nbsp;注&nbsp;&nbsp;册" type="submit">
            </div>

            <div class="form-group">
                <input value="重置" id="reset" class="form-control btn btn-danger" type="reset">
            </div>
        </form>

    </div>



@stop