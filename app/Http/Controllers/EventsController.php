<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventMember;
use App\Models\EventPrize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EventsController extends Controller
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
        $events = Event::paginate(5);
        return view('event/index',compact('events'));
    }


    //添加抽奖活动页面
    public function create()
    {
        //获取角色
//        $roles = Event::get();
        return view('event/create',compact('roles'));
    }
    //添加抽奖活动功能
    public function store(Request $request)
    {
        //验证数据
        $this->validate($request,[
            'title'=>'required|max:20|unique:events',
            'content'=>'required',
            'signup_start'=>'required',
            'signup_end'=>'required',
            'prize_date'=>'required',
            'signup_num'=>'required',
//            'is_prize'=>'required',
        ],[
            'title.required'=>'抽奖活动名不能为空',
            'title.max'=>'抽奖活动名不能大于20个字',
            'title.unique'=>'抽奖活动名已存在',
            'content.required'=>'详情不能为空',
            'signup_start.required'=>'报名开始时间不能为空',
            'signup_end.required'=>'报名结束时间不能为空',
            'prize_date.required'=>'开奖日期不能为空',
            'signup_num.required'=>'报名人数限制不能为空',
//            'is_prize.required'=>'是否开奖不能为空',
        ]);
//        dd($request->signup_start);
        $events = Event::create([
            'name'=>$request->name,
            'title'=>$request->title,
            'content'=>$request->content,
            'signup_start'=>strtotime($request->signup_start),
            'signup_end'=>strtotime($request->signup_end),
            'prize_date'=>$request->prize_date,
            'signup_num'=>$request->signup_num,
            'is_prize'=>0,//默认未开奖
        ]);
        //设置提示信息
        session()->flash('success','添加抽奖活动成功');
        return redirect()->route('events.index');//跳转到
    }


    //修改抽奖活动页面
    public function edit(Event $event)
    {
        return view('event/edit',compact('event'));
    }


    //修改抽奖活动功能
    public function update(Event $event,Request $request)
    {
        //验证数据
        $this->validate($request,[
            'title'=>['required','max:20',Rule::unique('events')->ignore($event->id)],
            'content'=>'required',
            'signup_start'=>'required',
            'signup_end'=>'required',
            'prize_date'=>'required',
            'signup_num'=>'required',
//            'is_prize'=>'required',
        ],[
            'title.required'=>'抽奖活动名不能为空',
            'title.max'=>'抽奖活动名不能大于20个字',
            'title.unique'=>'抽奖活动名已存在',
            'content.required'=>'详情不能为空',
            'signup_start.required'=>'报名开始时间不能为空',
            'signup_end.required'=>'报名结束时间不能为空',
            'prize_date.required'=>'开奖日期不能为空',
            'signup_num.required'=>'报名人数限制不能为空',
//            'is_prize.required'=>'是否开奖不能为空',
        ]);
        $event->update([
            'name'=>$request->name,
            'title'=>$request->title,
            'content'=>$request->content,
            'signup_start'=>strtotime($request->signup_start),
            'signup_end'=>strtotime($request->signup_end),
            'prize_date'=>$request->prize_date,
            'signup_num'=>$request->signup_num,
            'is_prize'=>$event->is_prize,//默认未开奖
        ]);
        //设置提示信息
        session()->flash('success','修改抽奖活动成功');
        return redirect()->route('events.index');//跳转到
    }

    //删除抽奖活动
    public function destroy(Event $event)
    {
        $event->delete();
        session()->flash('success','删除成功');
        return redirect()->route('events.index');//跳转
    }


    //查看
    public function show(Event $event)
    {
        return view('event/show',compact('event'));//跳转
    }



    //奖品内容页面
    public function prizes(Request $request)
    {
//        dd($request->id);
        //获得该活动的奖品
        $prizes = EventPrize::where('events_id',$request->id)->get();
//        $events_id = $prizes[0]->id??'';
        $events_id = $request->id;
        return view('event/prizes',compact(['prizes','events_id']));
    }

    //奖品内容添加页面
    public function prizesCreate(Request $request)
    {
//        dd($request->id);
        //获取指定活动
        $events = Event::find($request->id);
        return view('event/prizesCreate',compact('events'));
    }

    //奖品内容添加功能
    public function prizesStore(Request $request)
    {
//        dd($request->events_id);
        //验证数据
        $this->validate($request,[
            'events_id'=>'required',
            'name'=>'required|max:10|unique:event_prizes',
            'description'=>'required',
        ],[
            'events_id.required'=>'活动不能为空',
            'name.required'=>'奖品名不能为空',
            'name.max'=>'奖品名不能大于10个字',
            'name.unique'=>'该奖品已存在',
            'description.required'=>'奖品详情不能为空',
        ]);
//        dd($request->name);
        $prizes = EventPrize::create([
            'name'=>$request->name,
            'events_id'=>$request->events_id,
            'description'=>$request->description,
            'member_id'=>0,
        ]);
        //设置提示信息
        session()->flash('success','添加奖品内容成功');
        return redirect()->route('prizes.index',['id'=>$request->events_id]);//跳转到
    }

    //奖品内容修改页面
    public function prizesEdit(EventPrize $prize,Request $request)
    {
        //获取指定活动
        $events = Event::find($request->id);
//        dd($prize);
        return view('event/prizesEdit',compact(['events','prize']));
    }

    //奖品内容修改功能
    public function prizesUpdate(EventPrize $prize,Request $request)
    {
        //验证数据
        $this->validate($request,[
            'events_id'=>'required',
            'name'=>['required','max:10',Rule::unique('event_prizes')->ignore($prize->id)],
            'description'=>'required',
        ],[
            'events_id.required'=>'活动不能为空',
            'name.required'=>'奖品名不能为空',
            'name.max'=>'奖品名不能大于10个字',
            'name.unique'=>'该奖品已存在',
            'description.required'=>'奖品详情不能为空',
        ]);

        $prize->update([
            'name'=>$request->name,
            'events_id'=>$request->events_id,
            'description'=>$request->description,
            'member_id'=>$prize->member_id,
        ]);
        //设置提示信息
        session()->flash('success','修改抽奖活动成功');
        return redirect()->route('prizes.index',['id'=>$request->events_id]);//跳转到
    }

    //删除奖品内容
    public function prizesDestroy(EventPrize $prize,Request $request)
    {
//        dd($request->id);
        $prize->delete();
        session()->flash('success','删除成功');
        return redirect()->route('prizes.index',['id'=>$request->id]);//跳转['id'=>$request->id]是为了保证是本活动
    }


    //报名抽奖功能
    public function eventMember(Request $request)
    {
        //获得活动ID
        $event_id = $request->id;
        //根据活动ID获得该活动报名的人的ID
        $members = EventMember::where('events_id',$event_id)->get();
        $member_id = [];//获得所有ID
        foreach ($members as $member) {
            $member_id[] = $member->id;
        }
        //获取该活动所有奖品id
        $prizes = EventPrize::where('events_id',$event_id)->get();
        $prizes_id = [];//获得所有ID
        foreach ($prizes as $prize) {
            $prizes_id[] = $prize->id;
        }
        //打乱数组
        $new_member = shuffle($member_id);//打乱报名ID
        $new_prizes = shuffle($prizes_id);//打乱奖品ID//这个函数打乱的是原来的数组，这里应该调用$prizes_id这个原数组
        //遍历奖品(将所有奖品分配给报名人)
        $result = [];//获取结果  奖品id=》商家账号id
        foreach ($prizes_id as $k=>$prize) {
            if (!isset($member_id[$k])) break;//当没有报名的人时，跳出抽奖
            $result[$prize] = $member_id[$k];
        }

        //开启事务
        DB::beginTransaction();
        try{
            //得到奖品，保存数据库
            foreach ($result as $k=>$v){
                $event_prizes = EventPrize::find($k);
                $event_prizes->update([
                    'member_id'=>$v
                ]);
            }
            //抽奖成功时将活动改为已抽奖
            $event = Event::find($event_id);
            $event->update([
                'is_prize'=>1
            ]);
                //提交事务
                DB::commit();
            session()->flash('success','抽奖成功');
            return redirect()->route('events.index');
        } catch (\Exception $ex) {
            //回滚事务
            DB::rollback();
            //设置提示信息
            session()->flash('danger', '抽奖失败');
            return redirect()->route('events.index');//跳转到
        }
    }


}
