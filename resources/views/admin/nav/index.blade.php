@extends("layouts.admin.default")

@section("title","导航列表")

@section("content")

    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>ID</th>
            <th>导航名称</th>
            <th>url</th>
            <th>父级菜单</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        @foreach( $navs as $nav )
        <tr>

            <td>{{$nav->id}}</td>
            <td>{{$nav->name}}</td>
            <td>{{$nav->url}}</td>
            <td>{{$nav->pid}}</td>
            <td>{{$nav->sort}}</td>
            <td>
                <a class="btn btn-success" href="{{route("nav.edit",$nav->id)}}" role="button">编辑</a>
                <a class="btn btn-danger" href="{{route("nav.del",$nav->id)}}" role="button">删除</a>



            </td>


        </tr>
        @endforeach

    </table>


@stop