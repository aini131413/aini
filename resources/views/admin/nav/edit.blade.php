@extends("layouts.admin.default")

@section("title","编辑导航")

@section("content")
    <form class="form-horizontal" action="" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label class="col-sm-2 control-label">名称</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" value="{{$n->name}}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">路由</label>
            <div class="col-sm-10">
                <select name="url" class="form-control">
                    <option value="">请选择路由</option>
                    @foreach($urls as $url)
                        <option value="{{$url}}"
                        @if($n->url==$url)
                        selected
                            @endif
                        >{{$url}}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">上级菜单</label>
            <div class="col-sm-10">
                <select name="pid" class="form-control">
                    <option value="0">顶级分类</option>
                    @foreach($navs as $nav)
        <option value="{{$nav->id}}"
        @if($n->pid==$nav->id)
            selected
                @endif
        >
            {{$nav->name}}



                        </option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">排序</label>
            <div class="col-sm-10">
                <input type="text" name="sort" class="form-control" value="{{$n->sort}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">提交</button>
            </div>
        </div>
    </form>

@stop