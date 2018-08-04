<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">牛博客</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">主页 <span class="sr-only">(current)</span></a></li>
                <li><a href="http://admin.eleb.net/users">后台管理</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">前台管理 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('ceshi.index') }}">测试</a></li>
                        <li><a href="{{ route('users.index') }}">商家账号列表</a></li>
                        <li><a href="{{ route('menu_category.index') }}">菜品分类列表</a></li>
                        <li><a href="{{ route('menus.index') }}">菜品列表</a></li>
                        <li><a href="{{ route('orders.index') }}">订单列表</a></li>
                        <li><a href="{{ route('orderGoods.index') }}">订单商品列表</a></li>
                        <li><a href="{{ route('events.index') }}">抽奖活动列表</a></li>
                        <li><a href="{{ route('eventMembers.index') }}">活动报名列表</a></li>
{{--                        <li><a href="{{ route('prizes.index') }}">活动奖品列表</a></li>--}}
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control" name="keyword" placeholder="搜索...">
                </div>
                <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-zoom-in"></span></button>
            </form>
            <ul class="nav navbar-nav navbar-right">
            @guest
            <!-- Button trigger modal -->
                <a href="javascript:;"  class="btn btn-primary btn-lg" role="button" data-toggle="modal" data-target="#myModal">商家账号登录</a>
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">商家用户登录页面</h4>
                            </div>
                            <form action="{{ route('login.store') }}" class="" method="post">
                                <div class="modal-body">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">姓名</span>
                                        <input type="text" name="name" style="width:500px"  class="form-control" placeholder="小明?" aria-describedby="basic-addon1">
                                    </div><br>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon2">密码</span>
                                        <input type="password" name="password" style="width:500px" class="form-control" placeholder="123456...." aria-describedby="basic-addon1">
                                    </div><br>
                                    <span class=" input-group-addon" style="width: 100px">验证码</span>
                                    <input id="captcha" class="form-control" name="captcha" >
                                    <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" value="1"> 记住我
                                        </label>
                                    </div>
                                </div>
                                {{ csrf_field() }}
                                <div class="modal-footer">
                                    <a href="{{ route('users.create') }}">没有账号？注册一个？</a>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                    <button type="submit" class="btn btn-primary">确认登录</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endguest
                @auth
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('users.editPassword',['id'=>auth()->user()->id]) }}">修改密码</a></li>
                        <li><a href="#">个人信息</a></li>
                        <li><a href="#">接收信息</a></li>
                        <li><a href="#">控制台</a></li>
                        <li role="separator" class="divider"></li>
                        <li><form method="post" action="{{ route('login.logout') }}">
                        {{ csrf_field() }}{{ method_field('DELETE') }}
                        <button class="btn btn-link">退出登录</button>
                        </form>
                        </li>
                    </ul>
                </li>
                @endauth
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>