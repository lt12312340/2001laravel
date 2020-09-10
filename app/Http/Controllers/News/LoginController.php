<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;

class LoginController extends Controller
{
    public function login(){
        return view('news/login');
    }

    public function logindo(Request $request){
        //dd(encrypt(123));
        $user_name = $request->user_name;
        $user_pwd = $request->user_pwd;
        //echo $user_name.$user_pwd;
        $user= Users::where('user_name',$user_name)->first();
        //dd($user);
        if(!$user){
            return redirect('news/login')->with('msg','用户名不存在');die;
        }

        if(decrypt($user['user_pwd'])!=$user_pwd){
            return redirect('news/login')->with('msg','用户名或密码错误');die;
        }
        //request()->session()->put('man',$user['user_name']);
        request()->session()->put('user',$user);

        return redirect('news/list');


    }
}
