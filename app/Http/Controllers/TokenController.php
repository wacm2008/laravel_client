<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\EmpresaModel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
class TokenController extends Controller
{
    public function getAccessToken(Request $request){
        $app_id=$request->input('app_id');
        $app_key=$request->input('app_key');
        //每次请求200次
        $key_time='request_time'.$app_id;
        $num=Redis::get($key_time);
        if($num>200){
            die('超过日请求次数');
        }
        Redis::incr($key_time);
        Redis::expire($key_time,86400);
        
        if(empty($app_id)||empty($app_key)){
            die('参数不全');
        }
        $data=EmpresaModel::where(['app_id'=>$app_id])->first();
        if($data){
            if($app_key==$data->app_key){
                $key='access_token'.'_'.$data->uid;
                $redis_key='sadd_token';

                $token=str::random(8);
                Redis::set($key,$token);
                Redis::expire($key,3600);
                //保存到token集合
                Redis::Sadd($redis_key,$token);

                echo "token生成：".$token;
            }else{
                die('数据不匹配');
            }
        }else{
            die('无此信息');
        }
    }
}
