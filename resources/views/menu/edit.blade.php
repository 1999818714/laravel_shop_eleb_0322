@extends('default')

@section('contents')
<form class="form" method="post" action="{{ route('menus.update',[$menu]) }}" enctype="multipart/form-data">
    <h1 class="container">修改菜品页面2</h1>
    @include('_errors')
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">菜品2名</span>
        <input type="text" name="goods_name" style="width:500px"  class="form-control" placeholder="菜品分类名？" aria-describedby="basic-addon1"
               value="@if(old('goods_name')){{ old('goods_name') }}@else{{ $menu->goods_name }}@endif"
        >
    </div><br>
    <div  class="col-sm-4  input-group">
        <span class="input-group-addon" id="basic-addon1">所属商家</span>
        <select class="form-control" name="shop_id">
            @foreach($shops as $v)
                <option value="{{ $v->id }}" @if($v->id == $menu->shop_id)selected @endif  >{{ $v->shop_name }}</option>
            @endforeach
        </select>
    </div><br>
    <div  class="col-sm-4  input-group">
        <span class="input-group-addon" id="basic-addon1">所属分类</span>
        <select class="form-control" name="category_id">
            @foreach($menu_category as $v)
                <option value="{{ $v->id }}" @if($v->id == $menu->category_id)selected @endif >{{ $v->name }}</option>
            @endforeach
        </select>
    </div><br>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">价格</span>
        <input type="number" name="goods_price" style="width:500px"  class="form-control" placeholder="评分？" aria-describedby="basic-addon1"
               value="@if(old('goods_price')){{ old('goods_price') }}@else{{ $menu->goods_price }}@endif"
        >
    </div><br>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">描述</span>
        <textarea name="description" rows="5" cols="30">@if(old('description')){{ old('description') }}@else{{ $menu->description }}@endif</textarea>
    </div><br>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">提示信息</span>
        <textarea name="tips" rows="5" cols="30">@if(old('tips')){{ old('tips') }}@else{{ $menu->tips }}@endif</textarea>
    </div><br>
    <div class="form-group">
        <label for="exampleInputFile">商品图片</label>
        <div id="uploader-demo">
            <div id="fileList" class="uploader-list"></div>
            <div id="filePicker">选择图片</div>
        </div>
        <input type="text" name="goods_img" id="img_url" class="form-control" readonly>
        @if($menu->goods_img)
            <br>
            <img class="thumbnail img-responsive" id="img" src="{{ $menu->goods_img }}" width="200" />
        @endif
    </div><br>
    <div class="col-sm-2 input-group">
        <span class="input-group-addon" id="basic-addon1">状态</span>
        <select class="form-control" name="status">
                <option value="1" @if($menu->status==1)selected @endif >上架</option>
                <option value="0" @if($menu->status==0)selected @endif >下架</option>
        </select>
    </div><br>
    {{ method_field('PATCH') }}
    {{ csrf_field() }}
    <input type="submit" class="btn btn-primary" value="提交">
</form>
<br><br><br><br><br><br><br>
@stop

@section('js')
    <script >
        //使用Web Uploader上传图片到阿里云（只是上传图片）
        // 初始化Web Uploader
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
            //swf: BASE_URL + '/js/Uploader.swf',

            // 文件接收服务端。
            server: "{{ route('menus.upload') }}",

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            //文件上传请求的参数表，每次发送都会发送此对象中的参数
            formData:{
                _token:'{{ csrf_token() }}'
            }
        });
        //回显图片
        uploader.on( 'uploadSuccess', function( file,response ) {//uploadSuccess当文件上传成功时触发,response代表响应内容
            $("#img").attr('src',response.fileName);
            $("#img_url").val(response.fileName)
        });
        //文本编辑器
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
@stop
