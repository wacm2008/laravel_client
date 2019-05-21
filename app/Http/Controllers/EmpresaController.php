<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\EmpresaModel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
class EmpresaController extends Controller
{
    //企业注册
    public function register()
    {
        $data=EmpresaModel::where(['uid'=>Auth::id()])->first();
        if($data){
            return view('empresa/show',['data'=>$data]);
        }else{
            return view('empresa/register');
        }
    }
    public function reg(Request $request)
    {
        $data=$request->only(['e_name','e_corpo','e_impuesto','e_bcard','e_licencia']);
        $data['e_licencia']=$this->upload($request,'e_licencia');
        $data['uid']=Auth::id();
        $data['add_time']=time();
        //dd($data);
        $res=EmpresaModel::insert($data);

    }
    //文件上传
    public function upload(Request $request,$filename){
        //hasFile方法判断文件在请求中是否存在 isValid方法判断文件在上传过程中是否出错
        if ($request->hasFile($filename) && $request->file($filename)->isValid()){
            $photo = $request->file($filename);
            //手动创建文件名
            //获取后缀
            //$extension = $photo->getClientOriginalExtension();
            //获取文件名
            //$files=time().Str::random(8).'.'.$extension;
            //接收文件保存的相对路径 storeAS手动创文件名 store自动创建
            //$store_result = $photo->storeAS('licencia',$files);
            //自动创建文件名
            //$extension = $photo->extension();
            //$store_result = $photo->store('photo');
            //store 方法接收一个文件保存的相对路径
            $store_result = $photo->store('licencia/'.date('Ymd'));
            return $store_result;
        }
        exit('未获取到上传文件或上传过程出错');
    }
    public function userIp()
    {
        echo $_SERVER['REMOTE_ADDR'];
    }
    public function userAgent()
    {
        echo $_SERVER['HTTP_USER_AGENT'];
    }
    public function regInfo()
    {
        $app_id=$_GET['app_id'];
        EmpresaModel::where(['app_id'=>$app_id])->first();
    }
}
