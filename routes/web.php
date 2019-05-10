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