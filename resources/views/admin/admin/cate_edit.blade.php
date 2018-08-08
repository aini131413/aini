@extends("layouts.admin.default")

@section("title","编辑商铺分类")

@section("content")
    <div class="container" style="margin-top: 30px">

        <form action="" class="form-group" method="post" enctype="multipart/form-data">
            {{--分类名--}}
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <label for="name">分类名</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-tags"></span></span>
                    <input name="name" class="form-control" placeholder="请输入分类名" maxlength="20" type="text" value="{{old("name",$dd->name)}}">
                </div>
            </div>



            {{--图片--}}
            <div class="form-group has-feedback"
                 >
                <label for="img">图片</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-open-file"></span></span>
                    <input name="img" class="form-control" maxlength="20" type="file" >
                </div>
                @if($dd->img)
                    <img src="{{$dd->img}}" width="60px">
                @else
                   该分类没有相片···
                @endif
            </div>

            {{--选择状态                --}}
            <div class="form-group has-feedback">
            <label for="tags">状态</label>
            <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-record"></span></span>
                <div class="radio" >
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                <input  type="radio" name="status" value="0"
                @if($dd->status==0)
                    checked
                @endif
                > 未启用
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                <input type="radio" name="status"  value="1"
                       @if($dd->status)
                checked
                        @endif>  启用
                </div>

            </div>
            </div>
            <div class="form-group">
                <input class="form-control btn btn-primary" id="submit" value="立&nbsp;&nbsp;即&nbsp;&nbsp;修&nbsp;&nbsp;改" type="submit">
            </div>

            <div class="form-group">
                <input value="重置" id="reset" class="form-control btn btn-danger" type="reset">
            </div>
        </form>

    </div>



@stop