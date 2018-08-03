<?php

namespace App\Http\Controllers;

use App\Models\Order;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    //权限
    public function __construct()
    {
        $this->middleware('auth',[
//            'only'=>['info'],//（登录后可以查看的）该中间件只对这些方法生效
            'except'=>['index'],//（未登录可以查看的）该中间件除了这些方法，对其他方法生效
        ]);
    }

    //订单页面,按月搜索
    public function index(Request $request)
    {
        //搜索
        $keyword = '';
        $count = '';
        if($request->keyword){
            $keyword = $request->keyword;
            $counts = Order::where('created_at','like','%'.$keyword.'%')->count();
            $count = $keyword.'月份订单有'.$counts.'单';
            $orders = Order::where('created_at','like','%'.$keyword.'%')->paginate(5);//包含功能分页搜索
        }else{
            $counts = Order::count();
            $count = '全部订单有'.$counts.'单';
            $orders = Order::paginate(5);//包含功能分页
        }
        foreach ($orders as &$order){
            if($order->status == -1){
                $order->new_status = '已取消';
            }elseif ($order->status == 0){
                $order->new_status = '待支付';
            }elseif ($order->status == 1){
                $order->new_status = '待发货';
            }elseif ($order->status == 2){
                $order->new_status = '待确认';
            }elseif ($order->status == 3){
                $order->new_status = '完成';
            }
        }
        return view('order/index',compact(['orders','keyword','count']));
    }

    //订单页面,按日搜索
    public function index_day(Request $request)
    {
        //搜索
        $keyword = '';
        $count = '';
        if($request->keyword){
            $keyword = $request->keyword;
            $counts = Order::where('created_at','like','%'.$keyword.'%')->count();
            $count = $keyword.'日订单有'.$counts.'单';
            $orders = Order::where('created_at','like','%'.$keyword.'%')->paginate(5);//包含功能分页搜索
        }else{
            $counts = Order::count();
            $count = '全部订单有'.$counts.'单';
            $orders = Order::paginate(5);//包含功能分页
        }
        foreach ($orders as &$order){
            if($order->status == -1){
                $order->new_status = '已取消';
            }elseif ($order->status == 0){
                $order->new_status = '待支付';
            }elseif ($order->status == 1){
                $order->new_status = '待发货';
            }elseif ($order->status == 2){
                $order->new_status = '待确认';
            }elseif ($order->status == 3){
                $order->new_status = '完成';
            }
        }
        return view('order/index_day',compact(['orders','keyword','count']));//调用页面
    }


    //查看订单
    public function show(Order $order)
    {
        return view('order/show',compact('order'));
    }

    //订单状态
    public function status(Order $order,Request $request)
    {
        $status = $request->status;
        $order->update([
            'status'=>$status
        ]);
        if($status == -1){
            session()->flash('success','订单ID:'.$order->id.'取消成功');
        }elseif($status == 1){
            session()->flash('success','订单ID:'.$order->id.'支付成功');
        }elseif($status == 2){
            session()->flash('success','订单ID:'.$order->id.'发货成功');
        }
        return redirect()->route('orders.index');//跳转
    }




}
