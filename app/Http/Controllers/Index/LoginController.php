<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SendCode;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    //登录视图
    public function login(){
        return view('index/login');
    }

    //注册视图
    public function register(){
        return view('index/register');
    }

    //发送验证码
    public function sendcode(Request $request){
        $tel_eamil=$request->tel_email;
        // dd($tel_eamil);
        //判断tel_eamil是手机号还是邮箱
        $reg='/^1[3|4|5|6|7|8|9]\d{9}$/';
        $reg_email='/^\w{3,}@([a-z]{2,7}|[0-9]{3})\.(com|cn)$/';
        $code= rand(100000,999999);
        if(preg_match($reg,$tel_eamil)){
            return;
        }else if(preg_match($reg_email,$tel_eamil)){
            //邮箱发送验证码
            $this->sendMail($tel_eamil,$code);
            $request->session()->put('code',$code);
            return json_encode(['code'=>'00000','msg'=>'邮件发送成功']);
        }else{
            return json_encode(['code'=>'00000','msg'=>'输入正确的手机号或邮箱']);
        }
    }

    //邮件发送验证码
    public function sendMail($mail,$code){
        return Mail::to($mail)->send(new SendCode($code));
    }
}
