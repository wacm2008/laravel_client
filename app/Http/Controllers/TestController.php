<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UsersModel;
class TestController extends Controller
{
	public function users(){
		$userInfo=UsersModel::get()->toArray();
        if($userInfo){
            $data=[
                'errorno'=>0,
                'msg'=>'ok',
                'data'=>$userInfo
            ];
        }
        $da=json_encode($data,true);
        var_dump($da);
	}
	public function usersA(){
		print_r($_POST);
	}
	public function usersB(){
		echo __METHOD__;
		print_r($_POST);
	}
	public function usersC(){
		$res=file_get_contents('php://input');
		echo $res;
	}
}
