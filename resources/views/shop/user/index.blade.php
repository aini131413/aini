@extends("layouts.shop.default")

@section("title","商家个人商铺信息")

@section("content")
    <h2 style="margin-top: 20px; ">搜索</h2>
    <form class="form-inline" method="get">
        {{csrf_field()}}
        <div class="form-group">
            <label >菜品分类</label>
            <select name="cate" class="form-control">
                <option value="" >请选择分类</option>
                @foreach($cates as $cate)
                    <option value="{{$cate->id}}" @if(request()->cate==$cate->id)
                        selected
                            @endif
                        >{{$cate->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>菜品名称</label>
            <input type="text" class="form-control"   name="menu" value="{{request()->menu}}">
            </select>
        </div>
        <div class="form-group">
            <label >价格区间</label>
            <input type="number" class="form-control" min="0"  placeholder="0" name="min_price">
            ----
            <input type="number" class="form-control" min="1"  placeholder="0" name="max_price">
        </div>
        <button type="submit" class="btn btn-default">快速查找</button>
    </form>
    <br>

    <h2 style="margin-top: 30px" >商家信息</h2>
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>商家id</th>
            <th>名称</th>
            <th>邮箱</th>
            <th>店铺名称</th>
            <th>操作</th>
        </tr>
        {{--@foreach( $users as $user)--}}
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                 <td>{{$user->shop->shop_name}}</td>
                <td>
                    <a class="btn btn-success" href="{{route("user.edit",$user->id)}}" role="button">编辑</a>
                </td>
            </tr>
    </table>

    <h2>商铺信息</h2>
    <table class="table table-bordered table-hover" style="text-align: center">
            <tr>
            <th>id</th>
            <th>店铺分类</th>
            <th>名称</th>
            <th>店铺图片</th>
            <th>评分</th>
            <th>是否品牌</th>
            <th>是否准时送达</th>
            <th>是否蜂鸟配送</th>
            <th>是否保标记</th>
            <th>是否票标记</th>
            <th>是否准标记</th>
            <th>起送金额</th>
            <th>配送费</th>
            <th>店公告</th>
            <th>优惠信息</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
            <tr>
                <td>{{$shop->id}}</td>
                <td>{{$shop->category->name}}</td>
                <td>{{$shop->shop_name}}</td>
                <td>
                    @if($shop->shop_img)
                        <img src="{{$shop->shop_img}}" width="80px" height="80px">
                    @else
                        <img src="/gangtiexia.jpg" width="60px" height="100px">
                    @endif
                </td>
                <td>{{$shop->shop_rating}}

                </td>
                <td>
                    @if($shop->brand==0)
                        否
                    @else
                        是
                    @endif


                </td>
                <td>
                    @if($shop->on_time==0)
                        否
                    @else
                        是
                    @endif
                </td>
                <td>
                    @if($shop->fengniao==0)
                        否
                    @else
                        是
                    @endif
                </td>

                <td>
                    @if($shop->bao==0)
                        否
                    @else
                        是
                    @endif </td>
                <td>
                    @if($shop->piao==0)
                        否
                    @else
                        是
                    @endif
                </td>
                <td>
                    @if($shop->zhun==0)
                        否
                    @else
                        是
                    @endif
                </td>
                <td>
                    {{$shop->start_send}}
                </td>
                <td>
                    {{$shop->send_cost}}

                </td>
                <td>
                    {{$shop->notice}}

                </td>
                <td>
                    {{$shop->discount}}

                </td>
                <td>
                    @if($shop->status==0)
                        待审
                    @elseif($shop->status==1)
                        正常
                    @elseif($shop->status==-1)
                        禁用
                    @endif
                </td>
                <td>
                    <a class="btn btn-success" href="{{route("shop.edit",$shop->id)}}" role="button">编辑</a>
                </td>
            </tr>
    </table>

    <h2 >菜品分类</h2>
    <a class="form-control btn btn-info" id="submit" href='{{route("menu_category.add",$shop->id)}}' >添&nbsp;&nbsp;加&nbsp;&nbsp;分&nbsp;&nbsp;类</a>
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>分类id</th>
            <th>名称</th>
            <th>分类编号</th>
            <th>商家ID</th>
            <th>描述</th>
            <th>是否默认分类</th>
            <th>操作</th>
        </tr>
        @foreach( $cates as $cate)
            <tr>
                <td>{{$cate->id}}</td>
                <td>{{$cate->name}}</td>
                <td>{{$cate->type_accumulation}}</td>
                <td>{{$cate->shop_id}}</td>
                <td>{{$cate->description}}</td>
                <td>
                    @if($cate->is_selected)
                        是
                    @else
                        否
                    @endif
                </td>
                <td>
                    <a class="btn btn-success" href="{{route("menu_category.edit",$cate->id)}}" role="button">编辑</a>
                    <a class="btn btn-danger" href="{{route("menu_category.del",$cate->id)}}" role="button">删除</a>
                </td>
            </tr>
        @endforeach
    </table>

    <h2 >菜品明细</h2>
    <a class="form-control btn btn-info" id="submit" href='{{route("menu.add",$shop->id)}}' >添&nbsp;&nbsp;加&nbsp;&nbsp;菜&nbsp;&nbsp;品</a>
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>菜品id</th>
            <th>名称</th>
            <th>评分</th>
            <th>商家ID</th>
            <th>分类id</th>
            <th>价格</th>
            <th>描述</th>
            <th>月销量</th>
            <th>评分数量</th>
            <th>提示信息</th>
            <th>满意度数量</th>
            <th>满意度评分</th>
            <th>菜品图片</th>
            <th>是否上架</th>
            <th>操作</th>
        </tr>
        @foreach( $menus as $menu)
            <tr>
                <td>{{$menu->id}}</td>
                <td>{{$menu->goods_name}}</td>
                <td>{{$menu->rating}}</td>
                <td>{{$menu->shop_id}}</td>
                <td>{{$menu->category_id}}</td>
                <td>{{$menu->goods_price}}</td>
                <td>{{$menu->description}}</td>
                <td>{{$menu->month_sales}}</td>
                <td>{{$menu->rating_count}}</td>
                <td>{{$menu->tips}}</td>
                <td>{{$menu->satisfy_count}}</td>
                <td>{{$menu->satisfy_rate}}</td>
                <td>
                @if($menu->goods_img)
                        <img src="{{$menu->goods_img}}" width="80px" height="80px">
                @else
                        <img src="/gangtiexia.jpg" idth="80px" height="80px">
                @endif
                </td>
                <td>
                    @if($menu->status)
                        是
                    @else
                        否
                    @endif
                </td>
                <td>
                    <a class="btn btn-success" href="{{route("menu.edit",$menu->id)}}" role="button">编辑</a>
                    <a class="btn btn-danger" href="{{route("menu.del",$menu->id)}}" role="button">删除</a>
                </td>
            </tr>
        @endforeach
    </table>

    <h2 style="margin-top: 20px; ">平台活动</h2>
    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>活动编号</th>
            <th>活动标题</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>内容</th>
        </tr>
        @foreach($actives as $active)
            <tr>
                <td>{{$active->id}}</td>
                <td>{{$active->title}}</td>
                <td>{{$active->start_time}}</td>
                <td>{{$active->end_time}}</td>
                <td>{!! $active->content !!}</td>
            </tr>
        @endforeach
    </table>

    <h2 style="margin-top: 20px; ">抽奖活动</h2>

    <table class="table table-bordered table-hover" style="text-align: center">
        <tr>
            <th>活动编号</th>
            <th>活动标题</th>
            <th>开始时间</th>
            <th>结束时间</th>
            <th>开奖时间</th>
            <th>内容</th>

            <th>我要报名</th>
        </tr>
        @foreach($events as $event)
            <tr>
                <td>{{$event->id}}</td>
                <td>{{$event->title}}</td>
                <td>{{$event->start_time}}</td>
                <td>{{$event->end_time}}</td>
                <td>{{$event->prize_time}}</td>
                <td>{!! $event->content !!}</td>
                <td>
                    @if(  $event->is_prize ==1)
                        <a class="btn btn-info" id="submit" href='{{route("user.win", $event->id)}}' >查看获奖人员名单</a>
                    @elseif(\App\Models\EventUser::where("user_id",$user->id)->where("event_id",$event->id)->first() )
                      已报名
                    @elseif(\App\Models\EventUser::where("event_id", $event->id)->count() >= \App\Models\Event::findOrFail($event->id)->num)
                        报名人数已满，请期待下次的报名活动···
                    @else
<a class="btn btn-info" id="submit" href='{{route("user.join",["uid"=>$user->id,"eid"=>$event->id ])}}' >报名</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>


@stop