@extends("layouts.admin.default")

@section("title","商铺分类列表")

@section("content")
    <a class="btn btn-info" href='{{route("admin.cate_add")}}' role="button" >添加</a>
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>分类id</th>
            <th>名称</th>
            <th>图片</th>
            <th>是否启用</th>
            {{--<th>浏览次数</th>--}}
            {{--<th>图片</th>--}}
            <th>操作</th>
        </tr>
        @foreach( $cates as $cate)
            <tr>
                <td>{{$cate->id}}</td>
                <td>{{$cate->name}}</td>
                <td>
                    @if($cate->img)
                        <img src="{{$cate->img}}" width="60px">
                    @else
                        <img src="/gangtiexia.jpg" width="60px" height="100px">
                    @endif
                </td>

                {{--<td>--}}

                {{--@if($cate->is_sale=="yes")--}}
                {{--是--}}
                {{--@else--}}
                {{--否--}}
                {{--@endif--}}

                {{--</td>--}}

                {{--<td></td>--}}
                {{--<td>--}}
                {{--@if($cate->logo)--}}
                {{--<img src="/{{$cate->logo}}" width="60px" height="60px">--}}
                {{--@else--}}
                {{--<img src="/gangtiexia.jpg" width="60px" height="60px">--}}
                {{--@endif--}}
                {{--</td>--}}
                <td>


                    @if($cate->status=="1")
                        已启用 &emsp;
                        <a class="btn btn-warning" href="{{route("admin.cateStatus",$cate->id)}}" role="button">禁用</a>
                    @else
                        已禁用 &emsp;
                        <a class="btn btn-info" href="{{route("admin.cateStatus",$cate->id)}}" role="button">启用</a>
                    @endif



                </td>
                <td>
                    {{--<a class="btn btn-info" href="/goods/out/{{$cate->id}}" role="button">详情</a>--}}

                    <a class="btn btn-success" href="{{route("admin.cate_edit",$cate->id)}}" role="button">编辑</a>
                    <a class="btn btn-danger" href="{{route("admin.cate_del",$cate->id)}}" role="button">删除</a>
                </td>
            </tr>
        @endforeach
    </table>

    {{$cates->links()}}


@stop

