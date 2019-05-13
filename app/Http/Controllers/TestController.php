<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UsersModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
class TestController extends Controller
{
    //凯撒加密
    public function cesarEncode($str,$n=3){
        $str='hola';
        $pass='';
        for($i=0;$i<strlen($str);$i++){
            $ascii=ord($str[$i])+$n;
            //echo $asc=chr($ascii);
            $pass .=chr($ascii);
        }
        return $pass;
    }
    //凯撒解密
    public function cesarDecode($pass,$n=3){
        $pa='';
        for($i=0;$i<strlen($pass);$i++){
            $ascii=ord($pass[$i])-$n;
            $pa .=chr($ascii);
        }
        return $pa;
    }
    public function cesar(){
        $str='hola';
        $pass=$this->cesarEncode($str,$n=3);
        $pa=$this->cesarDecode($pass,$n=3);
        echo $pass.'+'.$pa;
    }
    //对称加密
    public function opencode(){
        $data='hola';
        $method='AES-256-CBC';
        $key='bruno';
        $option=OPENSSL_RAW_DATA;
        $iv='0123456789abcdef';
        $enc=openssl_encrypt($data,$method,$key,$option,$iv);
        $base64=base64_encode($enc);
        echo $base64.'<hr>';
        $base=base64_decode($base64);
        $ope=openssl_decrypt($base,$method,$key,$option,$iv);
        echo $ope;
    }
    public function opcode(){
        $data=[
            'name'=>'isco',
            'banco_id'=>20190510
        ];
        $json=json_encode($data);
        $method='AES-256-CBC';
        $key='bruno';
        $option=OPENSSL_RAW_DATA;
        $iv='0123456789abcdef';
        //加密
        $enc=openssl_encrypt($json,$method,$key,$option,$iv);
        $base64=base64_encode($enc);
        //echo $base64;die;
        $url='http://api.1809a.com/test/opcode';
        //echo $url;die;
        // 创建一个新cURL资源
        $ch = curl_init();
        //echo $ch;die;
        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//浏览器不输出
        curl_setopt($ch, CURLOPT_POSTFIELDS,$base64);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);//发送raw数据
        // 抓取URL并把它传递给浏览器
        $cu=curl_exec($ch);
        //var_dump($cu);
        $errorcode=curl_errno($ch);
        if($errorcode>0){
            die('错误码：'.$errorcode);
        }
        // 关闭cURL资源，并且释放系统资源
        curl_close($ch);
    }
    //非对称加密
    public function rsaTest(){
        $data=[
            'name'=>'isco',
            'banco_id'=>20190510
        ];
        $json=json_encode($data);
        //加密
        $key=openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
        openssl_private_encrypt($json,$enc,$key);
        //var_dump($enc);
        $base64=base64_encode($enc);
        //var_dump($base64);
        $url='http://api.1809a.com/test/rsa';
        // 创建一个新cURL资源
        $ch = curl_init();
        //echo $ch;die;
        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//浏览器不输出
        curl_setopt($ch, CURLOPT_POSTFIELDS,$base64);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);//发送raw数据
        // 抓取URL并把它传递给浏览器
        $cu=curl_exec($ch);
        //var_dump($cu);
        $errorcode=curl_errno($ch);
        if($errorcode>0){
            die('错误码：'.$errorcode);
        }
    }
    //非对称加密签名
    public function firma(){
        $data=[
            'oid'=>'20190510',
            'amount'=>100,
            'title'=>'订单测试',
            'name'=>'isco'
        ];
        $json=json_encode($data,JSON_UNESCAPED_UNICODE);
        $key=openssl_get_privatekey('file://'.storage_path('app/keys/private.pem'));
        //用私钥对数据签名
        openssl_sign($json,$signature,$key);
        //var_dump($signature);
        $base64=base64_encode($signature);
        //echo $base64.'<hr>';
        $url='http://api.1809a.com/test/firma?firma='.urlencode($base64);
        //echo $url.'<hr>';
        // 创建一个新cURL资源
        $ch = curl_init();
        //echo $ch;die;
        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//浏览器不输出
        curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);//发送raw数据
        // 抓取URL并把它传递给浏览器
        $cu=curl_exec($ch);
        //var_dump($cu);
        $errorcode=curl_errno($ch);
        if($errorcode>0){
            die('错误码：'.$errorcode);
        }
    }
    //注册
    public function register(){
        $pwd1=request()->input('pwd1');
        $pwd2=request()->input('pwd2');
        if($pwd1!=$pwd2){
            die('密码和确认密码不一致');
        }
        $pwd=password_hash($pwd1,PASSWORD_DEFAULT);
        //邮箱验证
        $email=request()->input('email');
        $e=UsersModel::where(['email'=>$email])->first();
        if($e){
            die('邮箱存在');
        }
        $data=[
            'name'=>request()->input('name'),
            'email'=>$email,
            'pwd'=>$pwd
        ];
        $json=json_encode($data);
        //加密
        $key=openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
        openssl_private_encrypt($json,$enc,$key);
        //var_dump($enc);
        $base64=base64_encode($enc);
        //var_dump($base64);
        $url='http://api.1809a.com/test/register';
        // 创建一个新cURL资源
        $ch = curl_init();
        //echo $ch;die;
        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//浏览器不输出
        curl_setopt($ch, CURLOPT_POSTFIELDS,$base64);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);//发送raw数据
        // 抓取URL并把它传递给浏览器
        $cu=curl_exec($ch);
        //var_dump($cu);
        $errorcode=curl_errno($ch);
        if($errorcode>0){
            die('错误码：'.$errorcode);
        }
    }
    //登录
    public function login(){
       return view('user/login');
    }
    public function logindo(){
        $name=request()->input('name');
        $pwd=request()->input('pwd');
        $info=UsersModel::where(['name'=>$name])->first();
//        print_r($pwd);echo "<br>";
//        print_r($info->pwd);die;
        if($info){
            if(password_verify($pwd,$info->pwd)){
                $token=substr(sha1($info->uid.time().str::random(10)),5,15);
                $key='uid_token'.$_SERVER['REMOTE_ADDR'].$info->uid;
                $re=Redis::get($key);
                if($re){

                }else{
                    Redis::set($key,$token);
                    Redis::expire($key,604800);
                }
                setcookie('token',$re,time()+604800,'/','1809a.com',false,true);
            }else{
                die('登录失败');
            }
        }else{
            die('信息不正确');
        }
        $data=[
            'name'=>$name,
            'pwd'=>$pwd,
            'email'=>$info->email,
        ];
        $json=json_encode($data);
        $k=openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
        openssl_private_encrypt($json,$enc,$k);
        $base64=base64_encode($enc);
        $url='http://api.1809a.com/test/login';
        $ch = curl_init();
        //echo $ch;die;
        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//浏览器不输出
        curl_setopt($ch, CURLOPT_POSTFIELDS,$base64);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);//发送raw数据
        // 抓取URL并把它传递给浏览器
        $cu=curl_exec($ch);
        //var_dump($cu);
        $errorcode=curl_errno($ch);
        if($errorcode>0){
            die('错误码：'.$errorcode);
        }
    }
}
