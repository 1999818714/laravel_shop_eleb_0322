@extends('default')

@section('contents')
    <h1>查看商家信息.设置状态</h1>
    <strong>主键: </strong><span style="color: #3097d1">{{ $menu->id }}</span><br><br>
    <strong>名称: </strong><span style="color: #3097d1">{{ $menu->goods_name }}</span><br><br>
    <strong>评分: </strong><span style="color: #3097d1">{{ $menu->rating }}</span><br><br>
    <strong>所属商家ID: </strong><span style="color: #3097d1">{{ $menu->getShops->shop_name }}</span><br><br>
    <strong>所属分类ID: </strong><span style="color: #3097d1">{{ $menu->getMenuCategory->name }}</span><br><br>
    <strong>价格: </strong><span style="color: #3097d1">{{ $menu->goods_price }}</span><br><br>
    <strong>描述: </strong><span style="color: #3097d1">{{ $menu->description }}</span><br><br>
    <strong>月销量: </strong><span style="color: #3097d1">{{ $menu->month_sales }}</span><br><br>
    <strong>评分数量: </strong><span style="color: #3097d1">{{ $menu->rating_count }}</span><br><br>
    <strong>提示信息: </strong><span style="color: #3097d1">{{ $menu->tips }}</span><br><br>
    <strong>满意度数量: </strong><span style="color: #3097d1">{{ $menu->satisfy_count }}</span><br><br>
    <strong>满意度评分: </strong><span style="color: #3097d1">{{ $menu->satisfy_rate }}</span><br><br>
    <strong>商品图片: </strong><span style="color: #3097d1"><img src="{{ $menu->goods_img }}" width="100px" height="80px" alt=""></span><br><br>
    <strong>状态: </strong><span style="color: #3097d1">{{ $menu->status?'上架':'下架' }}</span><br><br>
    <a href="javascript:history.go(-1);" role="button" class="btn btn-default">返回</a>
    <br><br><br><br><br><br><br><br>
@endsection
