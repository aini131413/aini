@extends("layouts.admin.default")

@section("title","编辑商铺信息")

@section("content")
    <form action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class=".form-group-sm" style="margin-top: 20px;" >
            &emsp;&emsp;&emsp;<label>名称</label>
            <input type="text" name="shop_name" class="form-control" value="{{old("shop_name",$shop->shop_name)}}" placeholder="请输入店铺名称">
        </div>
        <div class="form-group" style="margin-top: 30px">
            &emsp;&emsp;&emsp; <label >品牌</label>
            <input type="radio" name="brand"  value="0"
            @if($shop->brand==0)
                checked
            @endif
            >否
            <input type="radio" name="brand" value="1"
                   @if($shop->brand)
                   checked
                    @endif
            >是
            &emsp;&emsp;&emsp;<label >准时达</label>
            <input type="radio" name="on_time"  value="0"
                   @if($shop->on_time==0)
                   checked
                    @endif
            >否
            <input type="radio" name="on_time" value="1"
                   @if($shop->on_time)
                   checked
                    @endif
            >是
            &emsp;&emsp;&emsp;<label >蜂鸟</label>
            <input type="radio" name="fengniao"  value="0"
                   @if($shop->fengniao==0)
                   checked
                    @endif
            >否
            <input type="radio" name="fengniao" value="1"
                   @if($shop->fengniao)
                   checked
                    @endif
            >是
            &emsp;&emsp;&emsp; <label >保</label>
            <input type="radio" name="bao"  value="0"
                   @if($shop->bao==0)
                   checked
                    @endif
            >否
            <input type="radio" name="bao" value="1"
                   @if($shop->bao)
                   checked
                    @endif
            >是
            &emsp;&emsp;&emsp;<label >票</label>
            <input type="radio" name="piao"  value="0"
                   @if($shop->piao==0)
                   checked
                    @endif
            >否
            <input type="radio" name="piao" value="1"
                   @if($shop->piao)
                   checked
                    @endif
            >是

            &emsp;&emsp;&emsp;<label >准</label>
            <input type="radio" name="zhun"  value="0"
                   @if($shop->zhun==0)
                   checked
                    @endif

            >否
            <input type="radio" name="zhun" value="1"
                   @if($shop->zhun)
                   checked
                    @endif

            >是
            &emsp;&emsp;
        </div>
        {{--图片展示--}}
        <div class="form-group">
            &emsp;&emsp;&emsp;<label >商铺原图片</label>
            @if($shop->shop_img)
                <img src="{{$shop->shop_img}}" width="60px" height="100px">
                @else
                该商铺未上传图片···
                @endif
        </div>
        {{--上传图片--}}
            <div class="form-group">
                &emsp;&emsp;&emsp;<label >图片上传</label>
            <input type="file" name="shop_img" style="display: inline-block">

        </div>
        {{--店铺分类--}}
            <div class="form-group">
            &emsp;&emsp;&emsp; <label >店铺分类</label>
            <select name="shop_category_id" >
                @foreach($cates as $cate)
                <option value="{{$cate->id}}"
                @if($cate->id === $shop->shop_category_id )
                    selected
                        @endif
                >{{$cate->name}}</option>
                    @endforeach
            </select>
            &emsp;&emsp;&emsp; <label >起送金额</label>
            <input type="text" name="start_send"  placeholder="请输入起送金额" value="{{old("start_send",$shop->start_send)}}" style="display: inline-block">
            &emsp;&emsp;&emsp;<label >配送费</label>
            <input type="text" name="send_cost"  placeholder="配送费" value="{{old("send_cost",$shop->send_cost)}}" style="display: inline-block">
        </div>
        {{--公告--}}
            <div class="form-group">
            &emsp;&emsp;&emsp;   <label >店公告</label>
            <textarea class="form-control" name="notice" rows="2">{{old("notice",$shop->notice)}}</textarea>
        </div>
        {{--优惠信息--}}
        <div class="form-group">
            &emsp;&emsp;&emsp;  <label >优惠信息</label>
            <textarea class="form-control" name="discount" rows="2">{{old("discount",$shop->discount)}}</textarea>
        </div>
{{--验证码--}}
        {{--<div class="form-group has-feedback">--}}
            {{--&emsp;&emsp;&emsp; <label >验证码</label>--}}
       {{--<img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码" style="display: inline-block">--}}
 {{--<input   placeholder="请输入验证码"  type="text" name="captcha">--}}
            {{--</div>--}}




        <div class="form-group">

            <input class="form-control btn btn-primary" id="submit" value="立&nbsp;&nbsp;即&nbsp;&nbsp;修&nbsp;&nbsp;改" type="submit">
        </div>

        <div class="form-group">
            <input value="重置" id="reset" class="form-control btn btn-danger" type="reset">
        </div>














    </form>
@stop