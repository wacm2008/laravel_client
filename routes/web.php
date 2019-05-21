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
Route::get('/phpinfo', function () {
    phpinfo();
});
//凯撒加密
Route::get('/test/encode','TestController@cesarEncode');
Route::get('/test/decode','TestController@cesarDecode');
Route::get('/test/code','TestController@cesar');
//对称加密
Route::get('/test/opencode','TestController@opencode');
Route::get('/test/opcode','TestController@opcode');
//非对称加密
Route::get('/test/rsa','TestController@rsaTest');
//非对称加密签名
Route::get('/test/firma','TestController@firma');
//注册练习
Route::post('/test/register','TestController@register');
//登录练习
Route::get('/test/login','TestController@login');
Route::post('/test/logindo','TestController@logindo');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//企业注册
Route::middleware('auth')->group(function (){
    Route::get('/e_register','EmpresaController@register')->name('/e_register')->middleware('auth');
    Route::post('/e_reg','EmpresaController@reg');
});
//获取token
Route::get('/e_token','TokenController@getAccessToken');
//ip ua 注册信息
Route::middleware(['checkToken','filtro'])->group(function (){
    Route::get('/e_ip','EmpresaController@userIp');
    Route::get('/e_user_agent','EmpresaController@userAgent');
    Route::get('/e_reg_info','EmpresaController@regInfo');
});
