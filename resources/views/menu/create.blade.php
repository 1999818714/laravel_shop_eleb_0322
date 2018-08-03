@extends('default')

@section('contents')
<form class="form" method="post" action="{{ route('menus.store') }}" enctype="multipart/form-data">
    <h1 class="container">添加菜品页面</h1>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">菜品名</span>
        <input type="text" name="goods_name" style="width:500px"  class="form-control" placeholder="菜品分类名？" aria-describedby="basic-addon1">
    </div><br>
    <div  class="col-sm-4  input-group">
        <span class="input-group-addon" id="basic-addon1">所属商家</span>
        <select class="form-control" name="shop_id">
            @foreach($shops as $v)
                <option value="{{ $v->id }}">{{ $v->shop_name }}</option>
            @endforeach
        </select>
    </div><br>
    <div  class="col-sm-4  input-group">
        <span class="input-group-addon" id="basic-addon1">所属分类</span>
        <select class="form-control" name="category_id">
            @foreach($menu_category as $v)
                <option value="{{ $v->id }}">{{ $v->name }}</option>
            @endforeach
        </select>
    </div><br>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">价格</span>
        <input type="number" name="goods_price" style="width:500px"  class="form-control" placeholder="价格？" aria-describedby="basic-addon1">
    </div><br>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">描述</span>
        <textarea name="description" rows="5" cols="30"></textarea>
    </div><br>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">提示信息</span>
        <textarea name="tips" rows="5" cols="30"></textarea>
    </div><br>
    <div class="form-group">
        <label for="exampleInputFile">商品图片</label>
        <div id="uploader-demo">
            <div id="fileList" class="uploader-list"></div>
            <div id="filePicker">选择图片</div>
        </div>
        <input type="text" name="goods_img" id="img_url" class="form-control" readonly>
        <img id="img"/>
    </div><br>
    <div class="col-sm-2 input-group">
        <span class="input-group-addon" id="basic-addon1">状态</span>
        <select class="form-control" name="status">
                <option value="1" >上架</option>
                <option value="0" >下架</option>
        </select>
    </div><br>
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
