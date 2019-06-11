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

//Route::get('/', function () {
//    return view('welcome');
//});


//不需要管理用户登录即可访问
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    //后台登录路由
    Route::get('login','LoginController@login');
    //后台登录处理路由
    Route::post('doLogin','LoginController@doLogin');
});

//三方验证码路由
Route::get('/code/captcha/{tmp}', 'Admin\LoginController@captcha');

//需要管理用户登录后才能访问
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'isLogin'],function(){
    //后台首页路由
    Route::get('index','LoginController@index');
    //后台欢迎页
    Route::get('welcome','LoginController@welcome');
    //后台管理用户注销
    Route::get('logout', 'LoginController@logout');

    //后台管理用户模块相关资源路由
    Route::resource('user','UserController');
    // 修改管理用户状态路由 启用 停用
    Route::post('user/changestatus','UserController@changeStatus');
    // 删除所有选中管理用户路由
    Route::post('user/del','UserController@delAll');

});

