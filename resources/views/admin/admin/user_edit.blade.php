@extends("layouts.admin.default")

@section("title","编辑商家信息")

@section("content")
    <div class="container" style="margin-top: 30px">

        <form action="" class="form-group" method="post">
            {{--用户名--}}
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <label for="username">用户名</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input name="name" class="form-control" placeholder="请输入用户名" maxlength="20" type="text" value="{{old("name",$row->name)}}">
                </div>
            </div>
            {{--邮箱--}}
            <div class="form-group has-feedback"s>
                <label for="email">邮箱</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                    <input name="email" class="form-control" placeholder="请输入邮箱地址" maxlength="20" type="email" value="{{old("email",$row->email)}}">
                </div>
            </div>
           {{--验证码--}}
            {{--<div class="form-group has-feedback">--}}
                {{--<label for="captcha">验证码</label>--}}
                {{--<div class="">--}}
                    {{--<img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">--}}
                    {{--<div class="input-group">--}}
                        {{--<span class="input-group-addon">--}}
              {{--<span class="glyphicon glyphicon-qrcode"></span></span>--}}
                        {{--<input id="" class="form-control" placeholder="请输入验证码" maxlength="20" type="text" name="captcha">--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="form-group">
                <input class="form-control btn btn-primary" id="submit" value="进&nbsp;&nbsp;行&nbsp;&nbsp;修&nbsp;&nbsp;改" type="submit">
            </div>

            <div class="form-group">
                <input value="重置" id="reset" class="form-control btn btn-danger" type="reset">
            </div>
        </form>

    </div>



@stop