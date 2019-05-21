<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class Filtro
{
    /**
     * Handle an incoming request.
     *过滤请求次数
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token=$_GET['access_token'];
        //http://client.1809a.com/e_ip?access_token=DgqeuKR0
        //echo $_SERVER['REQUEST_URI'];//获取URL 只限制自己的接口 每个接口都是独立请求的
        $redis_key='filtro'.substr(md5($_SERVER['REQUEST_URI']),0,10);
        //echo $redis_key;die;
        Redis::incr($redis_key);
        Redis::expire($redis_key,60);
        $num=Redis::get($redis_key);
        if($num>20){
            //防恶意请求
            Redis::expire($redis_key,3600);
            die('超过请求限制次数');
        }
        return $next($request);
    }
}
