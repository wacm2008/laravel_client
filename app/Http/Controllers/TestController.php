<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
