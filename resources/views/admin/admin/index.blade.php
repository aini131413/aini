@extends("layouts.admin.default")

@section("title","管理员列表")

@section("content")
    <a class="btn btn-info" href='{{route("admin.add")}}' role="button" >添加</a>
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>管理员id</th>
            <th>姓名</th>
            <th>邮箱</th>
            <th>权限</th>
            <th>操作</th>
        </tr>
        @foreach( $admins as $admin)
            <tr>
                <td>{{$admin->id}}</td>
                <td>{{$admin->name}}</td>
                <td>{{$admin->email}}</td>
                <td>{{str_replace(['[',']','"'],'',json_encode($admin->getRoleNames(),JSON_UNESCAPED_UNICODE))}}</td>
                <td>
                    <a class="btn btn-success" href="{{route("admin.edit",$admin->id)}}" role="button">编辑</a>
                    <a class="btn btn-danger" href="{{route("admin.del",$admin->id)}}" role="button">删除</a>
                </td>
            </tr>
        @endforeach
    </table>

    {{$admins->links()}}


@stop