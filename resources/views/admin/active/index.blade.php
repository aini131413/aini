@extends("layouts.admin.default")

@section("title","活动列表")

@section("content")
    <h2 style="margin-top: 20px; ">搜索</h2>
    <form class="form-inline"  action="">
        {{csrf_field()}}
        <div class="form-group">
            <label >活动时间</label>
            <select name="search" class="form-control" >
                <option value="" selected>请选择活动时期</option>
                    <option value="start" @if(request()->search=="start")selected @endif>未开始</option>
                    <option value="doing" @if(request()->search=="doing")selected @endif>进行中</option>
                    <option value="end" @if(request()->search=="end")selected @endif>已结束</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">快速查找</button>
    </form>
    <br>

    <a class="btn btn-info form-control" href='{{route("active.add")}}' role="button" >添加</a>
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>活动ID</th>
            <th>标题</th>
            <th>活动内容</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>操作</th>
        </tr>
        @foreach( $actives as $active)
         <tr>
             <td>{{$active->id}}</td>
             <td>{{$active->title}}</td>
             <td>{!! $active->content !!}</td>
             <td>{{$active->start_time}}</td>
             <td>{{$active->end_time}}</td>
             <td>
                    <a class="btn btn-success" href="{{route("active.edit",$active->id)}}" role="button">编辑</a>
                    <a class="btn btn-danger" href="{{route("active.del",$active->id)}}" role="button">删除</a>
                </td>
            </tr>
        @endforeach
    </table>

    {{$actives->appends($get)->links()}}


@stop