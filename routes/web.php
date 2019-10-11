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


// Route::group(['middleware' => ['login'],'prefix'=>'/wechat/'], function () {
Route::prefix('/wechat')->group(function(){
	Route::get('login','WechatController@login'); //微信第三方登陆
	Route::get('code','WechatController@code');  //
	
	Route::get('template_list','WechatController@template_list'); //模板列表
	Route::get('del_template','WechatController@del_template');  //模板删除
	Route::get('push_template','WechatController@push_template'); //推送模板消息

	Route::get('upload_source','WechatController@upload_source'); //上传素材添加
	Route::post('do_upload','WechatController@do_upload');  //素材添加执行
	Route::any('matterList','WechatController@matterList'); //素材展示

	Route::any('qrcode','WechatController@qrcode'); //生成二维码添加
	Route::any('qrcode_do','WechatController@qrcode_do'); //添加执行
	Route::any('qrcodelist','WechatController@qrcodelist'); //二维码展示

	Route::any('event','WechatController@event'); //微信接口消息回复

	Route::any('menuadd','WechatController@menuadd'); //菜单添加
	Route::any('menuadd_do','WechatController@menuadd_do'); //菜单添加执行
	Route::any('menulist','WechatController@menulist'); //菜单展示
	Route::any('matter','WechatController@matter'); //一键生成

	Route::any('conflist','WechatController@conflist'); //表白展示
	Route::any('confadd/{id}','WechatController@confadd'); //表白添加
	Route::any('confadd_do','WechatController@confadd_do'); //表白添加

	Route::any('bbslist','WechatController@bbslist'); //留言展示
	Route::any('bbsadd/{id}','WechatController@bbsadd'); //留言添加
	Route::any('bbsadd_do','WechatController@bbsadd_do'); //留言添加执行


	Route::any('index','WechatController@index'); //用户入库
	Route::any('info','WechatController@info'); //获取用户信息
	Route::any('qiandao','WechatController@qiandao'); //签到添加
	Route::any('qiandao_do','WechatController@qiandao_do'); //签到添加执行

	Route::any('addnews','WechatController@addnews'); //调新闻接口添加
	Route::any('listnews','WechatController@listnews'); //调新闻接口展示
	
	Route::any('bangadd','WechatController@bangadd'); //登陆添加
	Route::any('bangadd_do','WechatController@bangadd_do'); //登陆添加执行
	Route::any('yan','WechatController@yan'); //发送验证码
	Route::any('dingadd','WechatController@dingadd'); //绑定账号添加
	Route::any('dingadd_do','WechatController@dingadd_do'); //绑定账号添加
});
//调新闻接口展示
Route::get('/wechat/newslist',function(){
	return view('wechat.newslist');
});

Route::prefix('/signin')->group(function(){
	Route::any('add','SigninController@add');
	Route::any('add_do','SigninController@add_do');
	Route::any('hai','SigninController@hai');


	Route::any('signinaddd','SigninController@signinaddd'); //接口添加
	Route::any('list','SigninController@list'); //接口展示
	Route::any('del','SigninController@del'); //接口删除
	Route::any('find','SigninController@find');
	Route::any('save','SigninController@save');
});


//restfu风格路由

//用户信息
Route::resource('posts','Api\PostController');

//用户信息接口添加页面
Route::get('/signin/signinadd',function(){
	return view('signin.signinadd');
});
//用户信息接口展示页面
Route::get('/signin/index',function(){
	return view('signin.index');
});
//用户信息接口修改页面
Route::get('/signin/signinsave',function(){
	return view('signin.signinsave');
});


//练习用户信息
Route::resource('contentt','Api\ContentController');
//用户信息接口添加页面
Route::get('/content/add',function(){
	return view('content.add');
});
//用户信息接口展示页面
Route::get('/content/list',function(){
	return view('content.list');
});
//用户信息接口修改页面
Route::get('/content/save',function(){
	return view('content.save');
});

Route::get('content/aes','Api\ContentController@aes');

//登陆注册
Route::prefix('/news')->group(function(){
	Route::any('regadd','NewsController@regadd');
	Route::any('regadd_do','NewsController@regadd_do');
	Route::any('log','NewsController@log');
	Route::any('login_do','NewsController@login_do');
});

Route::any('/news/login',function(){
	return view('news.login');
});
