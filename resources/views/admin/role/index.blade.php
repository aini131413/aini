@extends("layouts.admin.default")

@section("title","角色列表")

@section("content")
    <a class="btn btn-success" href="{{route("role.add")}}" role="button">添加角色</a>


    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>id</th>
            <th>名称</th>
            <th>权限</th>
            <th>操作</th>

        </tr>
        @foreach( $roles as $role)
            <tr>
                <td>{{$role->id}}</td>
                <td>{{$role->name}}</td>
                <td>{{ str_replace(['[',']','"'],'', $role->permissions()->pluck('name')) }}</td>
                <td>
                    <a class="btn btn-info" href="{{route("role.edit",$role->id)}}" role="button">编辑</a>
                    <a class="btn btn-danger" href="{{route("role.del",$role->id)}}" role="button">删除</a>
                </td>





            </tr>
        @endforeach
    </table>



@stop