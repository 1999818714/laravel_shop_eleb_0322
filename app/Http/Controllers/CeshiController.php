<?php

namespace App\Http\Controllers;

use App\Models\Ceshi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CeshiController extends Controller
{
    //测试上传图片到阿里云服务器配置是否成功
    public function index(){
        return view('ceshi/index');
    }
    //测试上传图片到阿里云服务器配置是否成功
    public function create(){
        return view('ceshi/create');
    }
    //测试上传图片到阿里云服务器配置是否成功
    public function store(Request $request){
//        $storage = Storage::disk('oss');
//        $fileName = $storage->putFile('ceshis',$request->img);//ceshis是保存文件夹
//        dd($request->img);
        Ceshi::create([
            'name'=>$request->name,
            'img'=>$request->img,//保存完整路径
            'status'=>0,
        ]);

    }
    //文件接收服务端
    public function upload()
    {
        $storage = \Illuminate\Support\Facades\Storage::disk('oss');
        $fileName = $storage->putFile('upload',request()->file('file'));//upload,file名字是在控制台错误文件header下找到的
        return [
            'fileName'=>$storage->url($fileName)//fileName作为响应内容名
        ];
    }

}
