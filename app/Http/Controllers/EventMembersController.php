<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class EventMembersController extends Controller
{
    //权限
    public function __construct()
    {
        $this->middleware('auth',[
//            'only'=>['info'],//（登录后可以查看的）该中间件只对这些方法生效
            'except'=>['index'],//（未登录可以查看的）该中间件除了这些方法，对其他方法生效
        ]);
    }

    //活动抽奖列表页面
    public function index()
    {
        //获得活动数据
        $eventMembers = EventMember::paginate(5);//带分页
        return view('eventMember/index',compact('eventMembers'));
    }

//    //报名
//    public function store(Request $request)
//    {
//        $events_id = $request->id;//活动ID
//        $member_id = Auth::user()->id;//商家账号ID
//        $events_num = Event::find($events_id)->signup_num;//获得活动限定报名人数
//        $members_num = EventMember::where('events_id',$events_id)->count();//查询已经报名了的人数
//        if($events_num > $members_num){
////            dd(1);
//            $eventMembers = EventMember::create([
//                'events_id'=>$events_id,
//                'member_id'=>$member_id,
//            ]);
//            //设置提示信息
//            session()->flash('success','报名成功');
//            return redirect()->route('events.index');//跳转到
//        }else{
////            dd(0);
//            //设置提示信息
//            session()->flash('danger','报名失败!名额已满');
//            return redirect()->route('events.index');//跳转到
//        }
//    }

    //报名，使用Redis缓存实现报名
    public function store(Request $request)
    {
        $id = $request->id;//活动ID
        $events = Event::find($id);
        $members_num = EventMember::where('events_id',$id)->count();//查询已经报名了的人数
        //先统计报名人数
//        phpinfo();
        $total = Redis::incr('total_'.$events->id);//自增一
        //判断报名人数是否已满,和剩余报名限制人数相比
        if($total > $events->signup_num-$members_num){
            Redis::decr('total_'.$events->id);//自减一
//            dd($total);
            //设置提示信息
            session()->flash('danger','报名失败!名额已满');
            return redirect()->route('events.index');
        }
            //如果没满，则提交报名信息
            $eventMembers = EventMember::create([
                'events_id'=>$events->id,
                'member_id'=>Auth::user()->id,
            ]);
        //设置提示信息
        session()->flash('success','报名成功');
        return redirect()->route('events.index');//跳转到
    }

}
