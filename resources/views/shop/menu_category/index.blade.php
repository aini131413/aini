@extends("layouts.shop.default")

@section("title","菜品分类列表")

@section("content")
    {{--<a class="btn btn-info" href='{{route("menu_category.add")}}' role="button" >添加</a>--}}
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>分类id</th>
            <th>名称</th>
            <th>分类编号</th>
            <th>商家ID</th>
            <th>描述</th>
            <th>是否默认分类</th>
            <th>操作</th>
        </tr>
        @foreach( $cates as $cate)
            <tr>
                <td>{{$cate->id}}</td>
                <td>{{$cate->name}}</td>
                <td>{{$cate->type_accumulation}}</td>
                <td>{{$cate->shop_id}}</td>
                <td>{{$cate->description}}</td>
                <td>
                    @if($cate->is_selected)
                    是
                    @else
                    否
                     @endif
                </td>
                <td>
                    <a class="btn btn-success" href="{{route("menu_category.edit",$cate->id)}}" role="button">编辑</a>
                    <a class="btn btn-danger" href="{{route("menu_category.del",$cate->id)}}" role="button">删除</a>
                </td>
            </tr>
        @endforeach
    </table>

    {{$cates->links()}}


@stop