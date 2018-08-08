@extends("layouts.shop.default")

@section("title","添加菜品分类")

@section("content")
    <div class="container" style="margin-top: 30px">


        <form action="" class="form-group" method="post">
            {{--用户名--}}
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <label for="name">分类名称</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input name="name" class="form-control" placeholder="分类名称" maxlength="20" type="text"
                           value="{{old("name")}}">
                </div>
            </div>
            <div class="form-group has-feedback">
                <label for="type_accumulation">分类编号</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input name="type_accumulation" class="form-control" placeholder="分类编号" maxlength="20" type="text"
                           value="{{old("type_accumulation")}}">
                </div>
            </div>
            <div class="form-group has-feedback">
                <label for="type_accumulation">所属商家</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input type="hidden" value="{{$shop_id}}" name="shop_id">

                    {{--{{var_dump($shops)}}--}}
                    <select name="shop_id" class="form-control" disabled>
                        {{--<option  selected>请选择</option>--}}
                        @foreach($shops as $shop)
             <option value="{{$shop->id}}"
             @if($shop_id==$shop->id)
                 selected
                 @endif
             >{{$shop->shop_name}}</option>
                         @endforeach
                    </select>

                </div>
            </div>
            <div class="form-group has-feedback">
                <label for="description">描述</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input name="description" class="form-control" placeholder="描述" maxlength="20" type="text"
                           value="{{old("description")}}">
                </div>
            </div>
            <div class="form-group has-feedback">
                <label for="is_selected">是否为默认分类</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>&emsp;&emsp;&emsp;&emsp;&emsp;
                    <input name="is_selected" type="radio" value="1">是 &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <input name="is_selected" type="radio" value="0" checked>否
                </div>
            </div>
            <div class="form-group">
                <input class="form-control btn btn-primary" id="submit" value="立&nbsp;&nbsp;即&nbsp;&nbsp;添&nbsp;&nbsp;加"
                       type="submit">
            </div>

            <div class="form-group">
                <input value="重置" id="reset" class="form-control btn btn-danger" type="reset">
            </div>
        </form>

    </div>



@stop