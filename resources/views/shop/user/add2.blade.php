@extends("layouts.shop.default")

@section("title","商家注册")

@section("content")
    <div class="container" style="margin-top: 30px">

        <form action="" class="form-group" method="post" enctype="multipart/form-data">
            {{--用户名--}}
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <label for="username">用户名</label>
                <div class="input-group">
                 <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input name="name" class="form-control" placeholder="请输入用户名" maxlength="20" type="text" value="{{old("name")}}">
                </div>
            </div>
            {{--邮箱--}}
            <div class="form-group has-feedback">
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
                    <input name="password" class="form-control" placeholder="请输入密码" maxlength="20" type="password" >
                </div>
            </div>
{{--商铺注册--}}
            <div class=".form-group-sm" style="margin-top: 20px;" >
            <label>店铺名称</label>
            <input type="text" name="shop_name" class="form-control" value="{{old("shop_name")}}" placeholder="请输入店铺名称">
            </div>
            <div class="form-group" style="margin-top: 30px">
             <label >品牌</label>
                <input type="radio" name="brand"  value="0" checked>否
                <input type="radio" name="brand" value="1">是
             &emsp;&emsp;<label >准时达</label>
                <input type="radio" name="on_time"  value="0" checked>否
                <input type="radio" name="on_time" value="1">是
             &emsp;&emsp;<label >蜂鸟</label>
                <input type="radio" name="fengniao"  value="0" checked>否
                <input type="radio" name="fengniao" value="1">是
             &emsp;&emsp;<label >保</label>
                <input type="radio" name="bao"  value="0" checked>否
                <input type="radio" name="bao" value="1">是
             &emsp;&emsp;<label >票</label>
                <input type="radio" name="piao"  value="0" checked>否
                <input type="radio" name="piao" value="1">是
             &emsp;&emsp;<label >准</label>
                <input type="radio" name="zhun"  value="0" checked>否
                <input type="radio" name="zhun" value="1">是
            </div>
            <div class="form-group">
             <label >店铺分类</label>
                <select name="shop_category_id" >
                    @foreach($cates as $cate)
                        <option value="{{$cate->id}}">{{$cate->name}}</option>
                    @endforeach
                </select>
             <label >起送金额</label>
                <input type="text" name="start_send"  placeholder="请输入起送金额" value="{{old("start_send")}}" style="display: inline-block">
             <label >配送费</label>
                <input type="text" name="send_cost"  placeholder="配送费" value="{{old("send_cost")}}" style="display: inline-block">
             <label >图片上传</label>
                <input type="file" name="shop_img" style="display: inline-block">
            </div>
            <div class="form-group">
            <label >店公告</label>
                <textarea class="form-control" name="notice" rows="2">{{old("notice")}}</textarea>
            </div>
            <div class="form-group">
            <label >优惠信息</label>
                <textarea class="form-control" name="discount" rows="2">{{old("discount")}}</textarea>
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

                <input class="form-control btn btn-primary" id="submit" value="立&nbsp;&nbsp;即&nbsp;&nbsp;注&nbsp;&nbsp;册" type="submit">
            </div>

            <div class="form-group">
                <input value="重置" id="reset" class="form-control btn btn-danger" type="reset">
            </div>
        </form>

    </div>



@stop