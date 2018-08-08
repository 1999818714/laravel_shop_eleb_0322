<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//商家账号表
Route::resource('users','UsersController');
Route::get('/users/{user}/status', 'UsersController@status')->name('users.status');//禁用、开启
Route::get('/users/{admin}/editPassword', 'UsersController@editPassword')->name('users.editPassword');//修改管理员密码页面
Route::patch('/users', 'UsersController@updatePassword')->name('users.updatePassword');//修改管理员密码功能

//管理员登录
Route::get('/login','LoginController@index')->name('login');//用于未登录时返回页面
Route::post('/login','LoginController@store')->name('login.store');
Route::delete('/logout','LoginController@logout')->name('login.logout');

//菜品分类表
Route::resource('menu_category','MenuCategoryController');
//菜品表
Route::resource('menus','MenusController');
Route::post('menus/upload','MenusController@upload')->name('menus.upload');//文件图片接受服务端

//订单表
Route::resource('orders','OrdersController');
Route::get('/orders/{order}/status', 'OrdersController@status')->name('orders.status');//(-1:已取消,0:待支付,1:待发货,2:待确认,3:完成)
Route::get('/index_day', 'OrdersController@index_day')->name('orders.index_day');//按日搜索
Route::get('/quxiao', 'OrdersController@quxiao')->name('orders.quxiao');//按日搜索

//订单商品表
Route::resource('orderGoods','OrderGoodsController');
Route::get('/orderGoods_index_day', 'OrderGoodsController@index_day')->name('orderGoods.index_day');//按日搜索


//测试上传图片到阿里云服务器配置是否成功
Route::resource('ceshi','CeshiController');
Route::post('upload','CeshiController@upload')->name('upload');//文件图片接受服务端

//抽奖活动表
Route::resource('events','EventsController');
Route::get('/prizes','EventsController@prizes')->name('prizes.index');//活动奖品列表
Route::get('/prizes/create','EventsController@prizesCreate')->name('prizes.create');//添加活动奖品页面
Route::post('/prizes','EventsController@prizesStore')->name('prizes.store');//添加活动奖品功能
Route::get('/prizes/{prize}/edit','EventsController@prizesEdit')->name('prizes.edit');//修改活动奖品页面
Route::patch('/prizes/{prize}','EventsController@prizesUpdate')->name('prizes.update');//修改活动奖品功能
Route::delete('/prizes/{prize}','EventsController@prizesDestroy')->name('prizes.destroy');//删除活动奖品功能
Route::get('/eventsMembers','EventsController@eventMember')->name('eventsMembers.member');//活动奖品报名抽奖功能

//活动奖品表
//Route::resource('eventPrizes','EventPrizesController');
//活动报名表
Route::resource('eventMembers','EventMembersController');
Route::get('event_members','EventMembersController@store')->name('event_members.store');



//文件接收服务端
//Route::post('upload',function (){
//    $storage = \Illuminate\Support\Facades\Storage::disk('oss');
//    $fileName = $storage->putFile('upload',request()->file('file'));//upload,file名字是在控制台错误文件header下找到的
//    return [
//        'fileName'=>$storage->url($fileName)//fileName作为响应内容名
//    ];
//})->name('upload');


//Route::resource('articles','ArticlesController');
//Route::get('/articles', 'articlesController@index')->name('articles.index');//用户列表
//Route::get('/articles/{user}', 'articlesController@show')->name('articles.show');//查看单个用户信息
//Route::get('/articles/create', 'articlesController@create')->name('articles.create');//显示添加表单
//Route::post('/articles', 'articlesController@store')->name('articles.store');//接收添加表单数据
//Route::get('/articles/{user}/edit', 'articlesController@edit')->name('articles.edit');//修改用户表单
//Route::patch('/articles/{user}', 'articlesController@update')->name('articles.update');//更新用户信息
//Route::delete('/articles/{user}', 'articlesController@destroy')->name('articles.destroy');//删除用户信息
