<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function index()
    {
        return view('login/index');
    }
    //保存登录状态
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:10',
            'password'=>'required',
            //验证码
            'captcha' => 'required|captcha',
        ],[
            'name.required'=>'账号不能为空',
            'name.max'=>'账号不能大于10个字',
            'password.required'=>'密码不能为空',
            'captcha.required' => '验证码不能为空',
            'captcha.captcha' => '请输入正确的验证码',
        ]);
        //商户状态不是1正常，则商家账号不能登录
        $name = $request->name;
        $users = DB::table('users')->where('name',$name)->first();
//        dd($users->id);
        if(!empty($users)){
//            dd(11);
            if($users->status == 1){//判断是否被禁用
                if(Auth::attempt([//认证
                    'name'=>$request->name,
                    'password'=>$request->password//自动加密密码
                ],$request->remember)) {//认证通过
                    //设置提示信息
                    session()->flash('success','商家用户登录成功');
                    return redirect()->route('users.index');
                }else{//认证失败跳回去
                    //设置提示信息
                    session()->flash('danger','用户名或密码错误');
                    return redirect()->back();
                    //return back()->with('danger', '用户名或密码错误')->withInput();
                }
            }else{
                //设置提示信息
                session()->flash('success','商家用户登录失败(被禁用了喔！)');
                return redirect()->route('users.index');
            }
        }
//        dd(22);
        return back()->with('danger', '该用户不存在')->withInput();
    }

    //注销
    public function logout()
    {
        Auth::logout();
        return redirect()->route('users.index')->with('success', '商家用户退出成功');
    }
}
