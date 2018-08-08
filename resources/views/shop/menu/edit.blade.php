@extends("layouts.shop.default")

@section("title","编辑菜品")

@section("content")
    <div class="container">

        <form action="" class="form-group" method="post" enctype="multipart/form-data" style="margin-top: 30px">
            {{ csrf_field() }}
            <label style="margin-top: 15px">商品名称</label>
            <input type="text" class="form-control" name="goods_name"  value="{{$menu->goods_name}}">
            <input type="hidden" class="form-control" name="shop_id"  value="{{$menu->shop_id}}">
            <label >所属分类</label>
            <select name="category_id" class="form-control" >
                @foreach($cates as $cate)
                    <option value="{{$cate->id}}"
                    @if($cate->id==$menu->category_id)
                    selected
                    @endif
                    >{{$cate->name}}</option>
                @endforeach
            </select><br/>
            <label style="margin-top: 10px" >商品价格</label>
            <input type="text" class="form-control" name="goods_price"  value="{{$menu->goods_price}}">
            <label >商品描述</label>
            <input type="text" class="form-control" name="description"  value="{{$menu->description}}">
            <label >商品提示</label>
            <input type="text" class="form-control" name="tips" value="{{$menu->tips}}" >
            <label >商品原图片</label><br/>
            @if($menu->goods_img)
                <img src="{{$menu->goods_img}}" width="80px" height="80px"><br/>
            @else
                该商品暂缺图片<br/>
            @endif
            <label >请选择上传的图片</label>
            <input type="file" name="goods_img" class="form-control" >
            是否上架 <input type="radio" value="1" name="status"
                        @if($menu->status==1)
                        checked
                    @endif
            >上架
            <input type="radio" value="0" name="status"
                   @if($menu->status==0)
                   checked
                    @endif

            >下架
            <button class="form-control btn btn-info" id="submit" type="submit">
                编&nbsp;&nbsp;辑&nbsp;&nbsp;菜&nbsp;&nbsp;品
            </button>
        </form>

    </div>
@stop