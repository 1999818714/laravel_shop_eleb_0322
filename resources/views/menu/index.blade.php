@extends('default')

@section('contents')
   {{--菜品分类--}}
   {{--<div  class="col-sm-2  input-group">--}}
       {{--<span class="input-group-addon" id="basic-addon1">所属分类</span>--}}
       {{--<select class="form-control" name="category_id">--}}
           {{--<option value="">全部</option>--}}
           {{--@foreach($menu_category as $v)--}}
               {{--<option value="{{ $v->id }}">&nbsp;&nbsp;&nbsp;&nbsp;{{ $v->name }}</option>--}}
           {{--@endforeach--}}
       {{--</select> </div><br>--}}
   <form action="{{ route('menus.index') }}" class="navbar-form navbar-left" method="get">
       <div class="form-group">
           <input type="text" class="form-control" name="keyword" placeholder="菜品搜索...">
       </div>
       <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-zoom-in"></span></button>
   </form>
    {{--<button type="button" class="btn btn-default btn-lg active">豆腐</button>--}}
<table class="table  table-bordered table-striped">
    <tr>
        <th>id</th>
        <th>名称</th>
        <th>商品图片</th>
        <th>评分</th>
        <th>所属商家</th>
        <th>所属分类</th>
        <th>价格</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    @foreach($menus as $menu)
    <tr>
        <td>{{ $menu->id }}</td>
        <td>{{ $menu->goods_name }}</td>
        <td><img src="{{ $menu->goods_img }}" width="100px" height="80px" alt=""></td>
        <td>{{ $menu->rating }}</td>
        <td>{{ $menu->getShops->shop_name }}</td>
        <td>{{ $menu->getMenuCategory->name }}</td>
        <td>{{ $menu->goods_price }}</td>
        <td>{{ $menu->status?'上架':'下架' }}</td>
        <td>
            <a href="{{ route('menus.edit',[$menu]) }}" role="button" class="btn btn-primary">编辑</a>
            <a href="{{ route('menus.show',[$menu]) }}" role="button" class="btn btn-primary">查看详情</a>
            <form method="post" action="{{ route('menus.destroy',[$menu]) }}">
                {{ method_field('DELETE') }}{{--不写这个会报no message--}}
                {{ csrf_field() }}{{--不写这个会报时间那个错误--}}
                <button class="btn btn-danger">删除</button>
            </form>
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="9"><a href="{{ route('menus.create') }}"  role="button" class="btn btn-primary">添加菜品</a></td>
    </tr>
</table>
    {{ $menus->appends(['keyword'=>$keyword])->links() }}
@endsection



{{--id           	primary	主键--}}
{{--goods_name  	string	名称--}}
{{--rating	        float	评分//--}}
{{--shop_id	        int	    所属商家ID--}}
{{--category_id 	int	    所属分类ID--}}
{{--goods_price 	float	价格--}}
{{--description 	string	描述--}}
{{--month_sales	    int	    月销量//--}}
{{--rating_count	int	    评分数量//--}}
{{--tips	        string	提示信息--}}
{{--satisfy_count	int	    满意度数量//--}}
{{--satisfy_rate	float	满意度评分//--}}
{{--goods_img	    string	商品图片--}}
{{--status	        int	    状态：1上架，0下架--}}