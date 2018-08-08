@extends("layouts.admin.default")

@section("title","管理员注册")

@section("content")
    <div class="container" style="margin-top: 30px">

        <form action="" class="form-group" method="post">
            {{--用户名--}}
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <label for="username">用户名</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input name="name" class="form-control" placeholder="请输入用户名" maxlength="20" type="text" value="{{old("name")}}">
                {{--<!-- 实例化编辑器 -->
                    <script type="text/javascript">
                        var ue = UE.getEditor('container');
                        ue.ready(function() {
                            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
                        });
                    </script>--}}

                    <!-- 编辑器容器 -->
                    {{--<script id="container" name="content" type="text/plain"></script>--}}


                </div>
            </div>

            {{--邮箱--}}
            <div class="form-group has-feedback"
                 >
                <label for="email">邮箱</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                    <input name="email" class="form-control" placeholder="请输入邮箱地址" maxlength="20" type="email" value="{{old("email")}}">
                </div>
            </div>


            {{--密码--}}
            <div class="form-group has-feedback">
                <label for="password">密码</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input name="password" class="form-control" placeholder="默认为请输入密码" maxlength="20" type="text" value="123456">
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

            <label for="username">角色选择</label>
            <div class="input-group">
                @foreach($roles as $role )
                    <input name="role[]"   type="checkbox" value="{{$role->name}}">{{$role->name}}
                @endforeach




            </div>


            {{--验证码--}}
            <div class="form-group has-feedback">
                <label for="captcha">验证码</label>
                <div class="">
                    <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
                    <div class="input-group">
                        <span class="input-group-addon">
              <span class="glyphicon glyphicon-qrcode"></span></span>
                        <input id="" class="form-control" placeholder="请输入验证码" maxlength="20" type="text" name="captcha">
                    </div>
                </div>
            </div>



            <div class="form-group">

                <input class="form-control btn btn-primary" id="submit" value="立&nbsp;&nbsp;即&nbsp;&nbsp;添&nbsp;&nbsp;加" type="submit">
            </div>

            <div class="form-group">
                <input value="重置" id="reset" class="form-control btn btn-danger" type="reset">
            </div>
        </form>

    </div>



@stop