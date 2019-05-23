<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\UsersModel;
use Illuminate\Support\Facades\Redis;
class BootstrapController extends Controller
{
    public function login()
    {
        return view('boot/login');
    }
    public function logindo(Request $request)
    {
        $email=$request->input('email');
        $pwd=$request->input('pwd');
        $info=UsersModel::where(['email'=>$email])->first();
        if($info){
            if(password_verify($pwd,$info->pwd)){
                echo "欢迎登录 请签到";
            }else{
                echo "密码不对";die;
            }
        }else{
            echo "登录失败 名字或密码不对";die;
        }
        return view('boot/sign',['uid'=>$info['uid']]);
    }
    public function sign()
    {
        $uid=$_GET['uid'];
        $key='sign'.date('Y-m-d');
        $res=Redis::setBit($key,$uid,1);
        if($res){
            echo '已签到';
        }
        $re=Redis::bitCount($key);
    }
}
