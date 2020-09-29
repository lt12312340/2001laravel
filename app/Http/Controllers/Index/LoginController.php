<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SendCode;
use Illuminate\Support\Facades\Mail;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Illuminate\Support\Facades\Hash;
use App\Models\Index_user;

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

    //执行注册
    public function registerdo(Request $request){
        $post = $request->all();
        
        $code=$request->session()->get('code');
        //dd($code);
        //验证验证码是否正确
        if(request()->m1 != 2){
            return redirect('/register')->with('msg','请勾选品优购用户条款');
        }

        //用户名唯一性验证
        $user = Index_user::where('user_name',$post['user_name'])->first();
        if($user['user_name']==$post['user_name']){
            return redirect('/register')->with('msg','用户名已存在');
        }

        if($post['code']!=$code){
            return redirect('/register')->with('msg','验证码有误');
        }
        $reg_pwd = '/^[a-zA-Z\d]{6,18}$/';
        //判断两次密码是否一致
        if($post['user_pwd']!=$post['repassword']){
            return redirect('/register')->with('msg','两次密码不一致');
        }

        //入库
        $reg='/^1[3|4|5|6|7|8|9]\d{9}$/';
        $reg_email='/^\w{3,}@([a-z]{2,7}|[0-9]{3})\.(com|cn)$/';
        
        if(preg_match($reg,$post['tel_email'])){
            $post['user_tel']=$post['tel_email'];
        }else if(preg_match($reg_email,$post['tel_email'])){
            $post['user_email']=$post['tel_email'];
        }else{
            return redirect('/register')->with('msg','您的手机号或邮箱不对');
        }
        $post['user_pwd'] = bcrypt($post['user_pwd']);
        unset($post['repassword']);
        unset($post['tel_email']);
        unset($post['code']);
        unset($post['m1']);
        // dd($post);
        $res= Index_user::create($post);
        if($res){
            return redirect('/login');
        }
    }

    //执行登录
    public function logindo(Request $request){
        $post = $request->all();
        // dump($post);
        $user = Index_user::where('user_name',$post['user_name'])->first();
        // dd($user);
        if(!$user){
            return redirect('/login')->with('msg','用户名或手机号或邮箱不存在');
        }

        if(!Hash::check($post['user_pwd'], $user->user_pwd)){
            return redirect('/login')->with('msg','密码或用户名有误');
        }

        $request->session()->put('user',$user);
        if($user){
            return redirect('/');
        }

    }

    //退出登录
    public function loginout(Request $request){
        request()->session()->flush();
        return redirect('/');
    }

    //发送验证码
    public function sendcode(Request $request){
        $tel_eamil=$request->tel_email;
        // dd($tel_eamil);
        // dd($tel_eamil);
        //判断tel_eamil是手机号还是邮箱
        $reg='/^1[3|4|5|6|7|8|9]\d{9}$/';
        $reg_email='/^\w{3,}@([a-z]{2,7}|[0-9]{3})\.(com|cn)$/';
        $code= rand(100000,999999);
        if(preg_match($reg,$tel_eamil)){
            //手机发送验证码
            $res= $this->sendSms($tel_eamil,$code);
            //$res['Message']='OK';
            if($res['Message']=='OK'){
                    $request->session()->put('code',$code);
                    return json_encode(['code'=>'00000','msg'=>'短信发送成功']);
            }
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

    //短信发送验证码
    public function sendSms($mobile,$code){

        // Download：https://github.com/aliyun/openapi-sdk-php
        // Usage：https://github.com/aliyun/openapi-sdk-php/blob/master/README.md

        AlibabaCloud::accessKeyClient('LTAI4G5wNDAgKVcvYkL9WtmH', 'iHOqv22of1BcEUQ0LQIh51sUyc0jy3')
                                ->regionId('cn-hangzhou')
                                ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                                ->product('Dysmsapi')
                                // ->scheme('https') // https | http
                                ->version('2017-05-25')
                                ->action('SendSms')
                                ->method('POST')
                                ->host('dysmsapi.aliyuncs.com')
                                ->options([
                                                'query' => [
                                                'RegionId' => "cn-hangzhou",
                                                'PhoneNumbers' => $mobile,
                                                'SignName' => "快乐手抓饼",
                                                'TemplateCode' => "SMS_190274194",
                                                'TemplateParam' => "{code:$code}",
                                                ],
                                            ])
                                ->request();
            return $result->toArray(); 
        } catch (ClientException $e) {
            return $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            return $e->getErrorMessage() . PHP_EOL;
        }
    }
}
