@extends('default')

@section('contents')
<table class="table  table-bordered table-striped">
    <tr>
        <th>id</th>
        <th>菜品分类名</th>
        <th>随机字符串</th>
        <th>所属商家</th>
        <th>描述</th>
        <th>是否是默认分类</th>
        <th>操作</th>
    </tr>
    @foreach($menuCategory as $cate)
    <tr>
        <td>{{ $cate->id }}</td>
        <td>{{ $cate->name }}</td>
        <td>{{ $cate->type_accumulation }}</td>
        <td>{{ $cate->getShops->shop_name }}</td>
        <td>{{ $cate->description }}</td>
        <td>{{ $cate->is_selected?'是':'否' }}</td>
        <td>
            <a href="{{ route('menu_category.edit',[$cate]) }}" role="button" class="btn btn-primary">编辑</a>
            <form method="post" action="{{ route('menu_category.destroy',[$cate]) }}">
                {{ method_field('DELETE') }}{{--不写这个会报no message--}}
                {{ csrf_field() }}{{--不写这个会报时间那个错误--}}
                <button class="btn btn-danger">删除</button>
            </form>
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="7"><a href="{{ route('menu_category.create') }}" role="button" class="btn btn-primary">添加菜品分类</a></td>
    </tr>
</table>
    {{ $menuCategory/*->appends(['keyword'=>'水浒'])*/->links() }}
@endsection