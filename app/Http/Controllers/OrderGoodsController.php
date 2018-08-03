<?php

namespace App\Http\Controllers;

use App\Models\OrderGoods;
use Illuminate\Http\Request;

class OrderGoodsController extends Controller
{
    //权限
    public function __construct()
    {
        $this->middleware('auth',[
//            'only'=>['info'],//（登录后可以查看的）该中间件只对这些方法生效
            'except'=>['index'],//（未登录可以查看的）该中间件除了这些方法，对其他方法生效
        ]);
    }

    //订单商品页面,按月搜索
    public function index(Request $request)
    {
        //搜索
        $keyword = '';
        $count = '';
        if($request->keyword){
            $keyword = $request->keyword;
            $goods = OrderGoods::where('created_at','like','%'.$keyword.'%')->get();
            $counts = 0;
            foreach($goods as $good){
                $counts += $good->amount;
            }
            $count = $keyword.'月份菜品销量有'.$counts.'单';
            $orderGoods = OrderGoods::where('created_at','like','%'.$keyword.'%')->paginate(5);//包含功能分页搜索
        }else{
            $goods = OrderGoods::get();
            $counts = 0;
            foreach($goods as $good){
                $counts += $good->amount;
            }
            $count = '全部菜品销量有'.$counts.'单';
            $orderGoods = OrderGoods::paginate(5);//包含功能分页
        }
        return view('orderGoods/index',compact(['orderGoods','keyword','count']));
    }
    //订单商品页面,按日搜索
    public function index_day(Request $request)
    {
        //搜索
        $keyword = '';
        $count = '';
        if($request->keyword){
            $keyword = $request->keyword;
            $goods = OrderGoods::where('created_at','like','%'.$keyword.'%')->get();
            $counts = 0;
            foreach($goods as $good){
                $counts += $good->amount;
            }
            $count = $keyword.'日菜品销量有'.$counts.'单';
            $orderGoods = OrderGoods::where('created_at','like','%'.$keyword.'%')->paginate(5);//包含功能分页搜索
        }else{
            $goods = OrderGoods::get();
            $counts = 0;
            foreach($goods as $good){
                $counts += $good->amount;
            }
            $count = '全部菜品销量有'.$counts.'单';
            $orderGoods = OrderGoods::paginate(5);//包含功能分页
        }
        return view('orderGoods/index_day',compact(['orderGoods','keyword','count']));
    }
}
