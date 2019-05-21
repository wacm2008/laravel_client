<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class checkToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty($_GET['access_token'])){
            die('token不为空');
        }
        $redis_key='sadd_token';
        //验证access_token
        $res=Redis::sIsMember($redis_key,$_GET['access_token']);
        if($res==false){
            die('token验证失败');
        }
        return $next($request);
    }
}
