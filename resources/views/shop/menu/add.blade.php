@extends("layouts.shop.default")

@section("title","添加菜品")

@section("content")
    <div class="container">

        <form action="" class="form-group" method="post" enctype="multipart/form-data" style="margin-top: 30px">
            {{ csrf_field() }}

            <input type="text" class="form-control" name="goods_name" style="margin-top: 15px" placeholder="菜品名称">
            <input type="hidden" class="form-control" name="shop_id" style="margin-top: 15px" value="{{$shop_id}}">
            所属分类<select name="category_id" id="" style="margin-top: 15px">
                @foreach($cates as $cate)
                    <option value="{{$cate->id}}">{{$cate->name}}</option>
                @endforeach
            </select>
            <input type="text" class="form-control" name="goods_price" style="margin-top: 15px" placeholder="价格">
            <input type="text" class="form-control" name="description" style="margin-top: 15px" placeholder="描述">
            <input type="text" class="form-control" name="tips" placeholder="提示信息" style="margin-top: 15px">
            <label style="margin-top: 15px">请选择商品图片</label>
            <input type="file" name="goods_img" class="form-control" style="margin-top: 15px">
            是否上架 <input type="radio" value="1" name="status" style="margin-top: 15px">上架
            <input type="radio" value="0" name="status" checked>下架
            <button class="form-control btn btn-info" id="submit" type="submit">
                添&nbsp;&nbsp;加&nbsp;&nbsp;菜&nbsp;&nbsp;品
            </button>
        </form>

    </div>
@stop