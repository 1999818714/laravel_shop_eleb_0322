@extends('default')

@section('contents')
<form class="form" method="post" action="{{ route('menu_category.store') }}">
    <h1 class="container">添加菜品分类页面</h1>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">菜品分类名</span>
        <input type="text" name="name" style="width:500px"  class="form-control" placeholder="菜品分类名？" aria-describedby="basic-addon1">
    </div><br>
    <div  class="col-sm-4  input-group">
        <span class="input-group-addon" id="basic-addon1">所属商家</span>
        <select class="form-control" name="shop_id">
            @foreach($shops as $v)
                <option value="{{ $v->id }}">{{ $v->shop_name }}</option>
            @endforeach
        </select>
    </div><br>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">描述</span>
        <textarea name="description" rows="5" cols="30"></textarea>
    </div><br>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">设置为默认分类</span>
        <label class="checkbox-inline">
            <input type="checkbox" name="is_selected" value="1"> (点击选择)
        </label>
    </div><br>
    {{ csrf_field() }}
    <input type="submit" class="btn btn-primary" value="提交">
</form>
@endsection