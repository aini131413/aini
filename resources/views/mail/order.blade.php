@if($order->message !==null)
{{$order->message}}
@else
<h2>您有新的订单</h2>
订单编号是{{$order->sn}}
 @endif