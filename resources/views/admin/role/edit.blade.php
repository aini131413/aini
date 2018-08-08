@extends("layouts.admin.default")

@section("title","编辑角色")

@section("content")
    <div class="container" style="margin-top: 30px">

        <form action="" class="form-group" method="post">
            {{--用户名--}}
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <label for="username">编辑角色</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input name="name" class="form-control" placeholder="请输入角色名"  type="text" value="{{$role->name}}">





                </div>

                <label for="username">权限选择</label>
                <div class="input-group">
 @foreach($pers as $per )
<input name="per[]"   type="checkbox" value="{{$per->name}}"
@if($role->hasPermissionTo($per->name))
checked
@endif
>{{$per->name}}
@endforeach




                </div>
            </div>


            <div class="form-group">

                <input class="form-control btn btn-success" id="submit" value="确&nbsp;&nbsp;认&nbsp;&nbsp;修&nbsp;&nbsp;改" type="submit">
            </div>


        </form>

    </div>



@stop