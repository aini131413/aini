@extends("layouts.shop.default")

@section("title","商家登陆")

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
                </div>
            </div>
{{--密码--}}
            <div class="form-group has-feedback">
                <label for="password">密码</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input name="password" class="form-control" placeholder="请输入密码" maxlength="20" type="password" >
                </div>
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

                <input class="form-control btn btn-primary" id="submit" value="立&nbsp;&nbsp;即&nbsp;&nbsp;登&nbsp;&nbsp;录" type="submit">
            </div>

            <div class="form-group">
                <input value="重置" id="reset" class="form-control btn btn-danger" type="reset">
            </div>
        </form>

    </div>



@stop