@extends('default')

@section('contents')
    <h1>查看商家信息.设置状态</h1>
    <strong>用户:</strong><span style="color: #3097d1">{{ $order->getMembers->username }}</span><br><br>
    <strong>商家:</strong><span style="color: #3097d1">{{ $order->getShops->shop_name }}</span><br><br>
    <strong>订单编号:</strong><span style="color: #3097d1">{{ $order->sn }}</span><br><br>
    <strong>省:</strong><span style="color: #3097d1">{{ $order->province }}</span><br><br>
    <strong>市:</strong><span style="color: #3097d1">{{ $order->city }}</span><br><br>
    <strong>县:</strong><span style="color: #3097d1">{{ $order->county }}</span><br><br>
    <strong>详细地址:</strong><span style="color: #3097d1">{{ $order->address }}</span><br><br>
    <strong>收货人电话:</strong><span style="color: #3097d1">{{ $order->tel }}</span><br><br>
    <strong>收货人姓名:</strong><span style="color: #3097d1">{{ $order->name }}</span><br><br>
    <strong>价格:</strong><span style="color: #3097d1">{{ $order->total }}</span><br><br>
    <strong>第三方交易号（微信支付需要）:</strong><span style="color: #3097d1">{{ $order->out_trade_no }}</span><br><br>
    <strong>创造时间:</strong><span style="color: #3097d1">{{ $order->created_at }}</span><br><br>
    <strong>修改时间:</strong><span style="color: #3097d1">{{ $order->updated_at }}</span><br><br>
    <strong style="font-size: 5ex">当前状态: </strong><span style="color: #3097d1;font-size: 5ex">
        @if($order->status == -1)
                已取消
            @elseif ($order->status == 0)
                待支付
            @elseif ($order->status == 1)
                待发货
           @elseif ($order->status == 2)
                待确认
            @elseif ($order->status == 3)
                完成
            @endif
    </span><br><br>
    @if($order->status == -1){{--//取消--}}
        <a href="#" class="btn btn-primary" role="button" disabled>该订单已经取消！</a>
    @elseif($order->status==0){{--//待支付--}}
        <a href="{{ route('orders.status',[$order,'status'=>1]) }}" class="btn btn-primary" role="button">模拟确认支付</a>
        <a href="{{ route('orders.status',[$order,'status'=>-1]) }}" class="btn btn-primary" role="button">对方还没支付,确认取消订单？</a>
    @elseif($order->status==1){{--//待发货--}}
        <a href="{{ route('orders.status',[$order,'status'=>-1]) }}" class="btn btn-primary" role="button">对方已支付,确认取消订单？</a>
        <a href="{{ route('orders.status',[$order,'status'=>2]) }}" class="btn btn-primary" role="button">确认发货</a>
    @elseif($order->status==2){{--//待确认--}}
        <a href="#" class="btn btn-primary" role="button" disabled>已发货,不能取消订单！</a>
    @elseif($order->status==3){{--//完成--}}
        <span style="color: red">这单已经交易完成了喔！</span>
    @endif
    <a href="javascript:history.go(-1);" role="button" class="btn btn-default">点击返回</a>
    <br><br><br><br><br><br><br><br>
@endsection
{{--user_id                 用户ID--}}
{{--shop_id                 商家ID--}}
{{--sn                      订单编号--}}
{{--province                省--}}
{{--city                    市--}}
{{--county                  县--}}
{{--address                 详细地址--}}
{{--tel                     收货人电话--}}
{{--name                    收货人姓名--}}
{{--total                   价格--}}
{{--status                  状态(-1:已取消,0:待支付,1:待发货,2:待确认,3:完成)--}}
{{--out_trade_no            第三方交易号（微信支付需要）--}}