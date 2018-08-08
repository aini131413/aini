@extends("layouts.admin.default")

@section("title","商家列表")

@section("content")
    <a class="btn btn-info" href='{{route("admin.user_add")}}' role="button" >添加</a>
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>商家id</th>
            <th>名称</th>
            <th>邮箱</th>
            <th>密码</th>
            <th>店铺名称</th>
            <th>是否启用</th>
            {{--<th>浏览次数</th>--}}
            {{--<th>图片</th>--}}
            <th>操作</th>
        </tr>
        @foreach( $users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    <form action="{{route("admin.reset",$user->id)}}">
                        <input type="hidden" name="password" value="123456">
                        <input type="submit" value="重置密码">
                    </form>


                </td>
                {{--<td>--}}

                    {{--@if($user->is_sale=="yes")--}}
                        {{--是--}}
                    {{--@else--}}
                        {{--否--}}
                    {{--@endif--}}

                {{--</td>--}}

                <td>{{$user->shop->shop_name}}</td>
                {{--<td></td>--}}
                {{--<td>--}}
                    {{--@if($user->logo)--}}
                        {{--<img src="/{{$user->logo}}" width="60px" height="60px">--}}
                    {{--@else--}}
                        {{--<img src="/gangtiexia.jpg" width="60px" height="60px">--}}
                    {{--@endif--}}
                {{--</td>--}}
                <td>


                    @if($user->status=="1")
                    已启用 &emsp;
                    <a class="btn btn-warning" href="{{route("admin.status",$user->id)}}" role="button">禁用</a>
                    @else
                    已禁用 &emsp;
                     <a class="btn btn-info" href="{{route("admin.status",$user->id)}}" role="button">启用</a>
                    @endif



                </td>
                <td>
                    {{--<a class="btn btn-info" href="/goods/out/{{$user->id}}" role="button">详情</a>--}}

                    <a class="btn btn-success" href="{{route("admin.user_edit",$user->id)}}" role="button">编辑</a>
                    <a class="btn btn-danger" href="{{route("admin.user_del",$user->id)}}" role="button">删除</a>
                </td>
            </tr>
        @endforeach
    </table>

    {{$users->links()}}


@stop