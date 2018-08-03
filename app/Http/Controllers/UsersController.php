<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Users;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{

    //权限
    public function __construct()
    {
        $this->middleware('auth',[
//            'only'=>['info'],//（登录后可以查看的）该中间件只对这些方法生效
            'except'=>['index'],//（未登录可以查看的）该中间件除了这些方法，对其他方法生效
        ]);
    }

    //商家账号列表
    public function index()
    {
//        if(!Auth::check()){//未登录
//            dd(11);
//        }
        return view('users/index');
    }
    //商家账号添加页面
    public function create()
    {
        //获取店铺分类ID和分类名
        $shopCategory = DB::table('shop_categories')->select('id','name')->get();
        return view('users/create',compact('shopCategory'));
    }
    //商家账号添加功能
    public function store(Request $request)
    {
        //验证数据
        $this->validate($request,[
            'name'=>'required|max:20|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|max:5|confirmed',

            'shop_name'=>'required',
            'shop_rating'=>'required',
            'start_send'=>'required',
            'send_cost'=>'required',
            'notice'=>'required',
            'discount'=>'required',
        ],[
            'name.required'=>'商家账号名不能为空',
            'name.max'=>'商家账号名不能大于20个字',
            'name.unique'=>'商家账号名已存在',
            'email.required'=>'邮箱名不能为空',
            'email.email'=>'邮箱不能重复',
            'email.unique'=>'邮箱已存在',
            'password.required'=>'密码不能为空',
            'password.max'=>'密码不能小于5位',
            'password.confirmed'=>'密码和确认密码不相同',

            'shop_name.required'=>'名称不能为空',
            'shop_rating.required'=>'评分不能为空',
            'start_send.required'=>'起送金额(元)不能为空',
            'send_cost.required'=>'配送费(元)不能为空',
            'notice.required'=>'店公告不能为空',
            'discount.required'=>'优惠信息不能为空',
        ]);

        //处理上传文件
        $file = $request->shop_img;
        //使用这个要开启storage   php artisan storage:link
        $fileName = $file->store('public/shop_img');//获得保存图片路径，返回地址
        $img = Storage::url($fileName);//这样商户的图片后台也可以访问
        //开启事务
        DB::beginTransaction();
        try{
            //先添加商家信息
            $shop = Shop::create([
                'shop_category_id'=>$request->shop_category_id,
                'shop_name'=>$request->shop_name,
                'shop_img'=>url($img),
                'shop_rating'=>$request->shop_rating,
                'brand'=>$request->brand,
                'on_time'=>$request->on_time,
                'fengniao'=>$request->fengniao,
                'bao'=>$request->bao,
                'piao'=>$request->piao,
                'zhun'=>$request->zhun,
                'start_send'=>$request->start_send,
                'send_cost'=>$request->send_cost,
                'notice'=>$request->notice,
                'discount'=>$request->discount,
                'status'=>0//商家用户添加默认未审核
            ]);
            //后添加商家账号
            $shop_id = $shop->id;//获取所属商家
            Users::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
                'status'=>0,//商家用户添加默认未审核
                'shop_id'=>$shop_id
            ]);
            //提交事务
            DB::commit();
            //设置提示信息
            session()->flash('success','添加商家账号成功');
            return redirect()->route('users.index');//跳转到
        }catch (\Exception $ex){
            //设置提示信息
            session()->flash('danger','添加商家账号是失败');
            //回滚事务
            DB::rollback();
            return redirect()->route('users.create');//跳转到
        }
    }


//修改商家账号密码页面
    public function editPassword()
    {
//        dd(12);
        return view('users/editPassword');
    }
    //修改商家账号密码功能
    public function updatePassword(Request $request)
    {
        //验证数据
        $this->validate($request,[
            'oldpassword'=>'required',
            'password'=>'required|min:5|confirmed',
        ],[
            'name.max'=>'商家账号名不能大于20个字',
            'oldpassword.required'=>'旧密码不能为空',
            'password.required'=>'密码不能为空',
            'password.min'=>'密码不能小于5位',
            'password.confirmed'=>'密码和确认密码不相同',
        ]);
        $oldpassword = $request->oldpassword;//旧密码(未加密)
        $db_password = auth()->user()->password;//数据库原密码(加密的）
        if(Hash::check($oldpassword,$db_password)){//第一个不加密，第二个加密
            //验证成功，将填写密码加密放到数据库中
            $password = $request->password;
            $newPassword = bcrypt($password);//加密
            $id = auth()->user()->id;//获取当前商家账号登录的ID
            $user = Users::find($id);//获取当前商家账号的一行记录
            $user->update([
                'password'=>$newPassword,
            ]);
            //设置提示信息
            session()->flash('success','修改商家账号密码成功');
            return redirect()->route('users.index');//跳转到
        }else{
            session()->flash('danger','旧密码错误');
            return redirect()->back();//跳回去
        }
    }





}
