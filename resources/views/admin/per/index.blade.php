@extends("layouts.admin.default")

@section("title","权限列表")

@section("content")
    <a class="btn btn-success" href="{{route("per.add")}}" role="button">添加权限</a>

    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>id</th>
            <th>名称</th>
            <th>所属分类</th>
            <th>操作</th>

        </tr>
        @foreach( $pers as $per)
            <tr>
                <td>{{$per->id}}</td>
                <td>{{$per->name}}</td>
                <td>{{$per->guard_name}}</td>
                <td>

                    <a class="btn btn-danger" href="{{route("per.del",$per->id)}}" role="button">删除</a>
                </td>





            </tr>
        @endforeach
    </table>



@stop