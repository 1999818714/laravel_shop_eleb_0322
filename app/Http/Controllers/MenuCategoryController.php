<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MenuCategoryController extends Controller
{
    //权限
    public function __construct()
    {
        $this->middleware('auth',[
//            'only'=>['info'],//（登录后可以查看的）该中间件只对这些方法生效
            'except'=>['index'],//（未登录可以查看的）该中间件除了这些方法，对其他方法生效
        ]);
    }

    //菜品分类列表
    public function index()
    {
//        dd(12);
        $menuCategory = MenuCategory::paginate(5);//包含功能分页
        return view('menuCategory/index',compact('menuCategory'));
    }
    //菜品分类添加页面
    public function create()
    {
        //获得商家信息
        $shops = DB::table('shops')->get();
        return view('menuCategory/create',compact('shops'));
    }
    //菜品分类添加功能
    public function store(Request $request)
    {
        //验证数据
        $this->validate($request,[
            'name'=>'required|max:20|unique:menu_categories',
            'description'=>'required',
        ],[
            'name.required'=>'菜品分类名不能为空',
            'name.max'=>'菜品分类名不能大于20个字',
            'name.unique'=>'菜品分类名已存在',
            'description.unique'=>'描述不能为空',
        ]);
        $shop_id = $request->shop_id;
        $is_selected = $request->is_selected??0;
        if($is_selected == 1){
        //将该商户的所有默认分类取消,后面再改
            DB::table('menu_categories')->where('shop_id',$shop_id)->update([
                'is_selected'=>0
            ]);
        }
        $model = MenuCategory::create([
            'name'=>$request->name,
            'shop_id'=>$request->shop_id,
            'description'=>$request->description,
            'is_selected'=>$is_selected,
            'type_accumulation'=>uniqid(),
        ]);
        //设置提示信息
        session()->flash('success','添加菜品分类名成功');
        return redirect()->route('menu_category.index');//跳转到
    }

     //菜品分类修改页面
    public function edit(MenuCategory $menuCategory)
    {
//        dd(11);
        //获得商家信息
        $shops = DB::table('shops')->get();
        return view('menuCategory/edit',compact(['shops','menuCategory']));
    }
    //菜品分类修改功能
    public function update(MenuCategory $menuCategory , Request $request)
    {
        //验证数据
        $this->validate($request,[
            'name'=>['required','max:20',Rule::unique('menu_categories')->ignore($menuCategory->id)],//除去本ID所属
            'description'=>'required',
        ],[
            'name.required'=>'菜品分类名不能为空',
            'name.max'=>'菜品分类名不能大于20个字',
            'name.unique'=>'菜品分类名已存在',
            'description.unique'=>'描述不能为空',
        ]);
        $shop_id = $request->shop_id;
        $is_selected = $request->is_selected??0;
        if($is_selected == 1){
        //将该商户的所有默认分类取消,后面再改
            DB::table('menu_categories')->where('shop_id',$shop_id)->update([
                'is_selected'=>0
            ]);
        }
        $model = $menuCategory->update([
            'name'=>$request->name,
            'shop_id'=>$request->shop_id,
            'description'=>$request->description,
            'is_selected'=>$is_selected,
//            'type_accumulation'=>'随机字符串',
        ]);
        //设置提示信息
        session()->flash('success','修改菜品分类名成功');
        return redirect()->route('menu_category.index');//跳转到
    }



    //删除菜品分类
    public function destroy(MenuCategory $menuCategory)
    {
        //查询菜品是否用了该分类
        $id = $menuCategory->id;
        $category = DB::table('menus')->where('category_id',$id)->first();
//        dd($category);
        if(empty($category)){
            $menuCategory->delete();
            session()->flash('success','删除菜品成功');
            return redirect()->route('menu_category.index');//跳转
        }
        session()->flash('danger','该菜品分类已被使用');
        return redirect()->route('menu_category.index');//跳转
    }
}
