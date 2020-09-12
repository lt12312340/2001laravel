<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Requests\StoreAdminPost;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
class AdminController extends Controller
{
    //登录
    public function login(){
        return view('admin.login');
    }
      //图片验证
    public function getCaptcha()
    {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象,配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色25,25,112
        $builder->setBackgroundColor(0, 0, 0);
        // 设置倾斜角度
        $builder->setMaxAngle(0);
        // 设置验证码后面最大行数
        $builder->setMaxBehindLines(0);
        // 设置验证码前面最大行数
        $builder->setMaxFrontLines(0);
        // 设置验证码颜色
        $builder->setTextColor(255, 255, 0);
        // 可以设置图片宽高及字体
        $builder->build($width = 150, $height = 40, $font = null);

        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        // 把内容存入session
        session()->put('CAPTCHA_IMG', $phrase);

        // 生成图片
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type:image/jpeg');
        $builder->output();
    }
    //执行登录
    public function logindo(Request $request){
        $admin_name =$request->admin_name;
        //dd($admin_name);
        $admin_pwd =$request->admin_pwd;
        $captcha=$request->captcha;
        //dd($captcha);
        $code = session()->get('CAPTCHA_IMG');
        //dd($code);
        $res=Admin::where('admin_account',$admin_name)->first();
        //dd($res);
        if(!$res){
            return redirect('/login')->with('msg','用户名有误');
        }
        if($admin_pwd!=decrypt($res['admin_pwd'])){
            return redirect('/login')->with('mng','密码错误');
        }
        //验证码
        if($captcha == '')
        {
            return redirect('/login')->with('mag','验证码不能为空');
        }
        if($captcha!=$code)
        {
            return redirect('/login')->with('mbg','验证码有误');
        }

        $request->session()->put('admin',$res);
        if($res){
            return redirect('/admin');
        }

    }
  

    //表单
    public function create(){
        return view('admin.admin.create');
    }
    //添加
    public function store(StoreAdminPost $request){
        $post = request()->except('_token');
        //dd($post);
        $post['admin_pwd'] = encrypt($post['admin_pwd']);
        //dd($post['admin_pwd']);
        $data=Admin::create($post);
        if($data){
            return redirect('/admin');
        }
    }
    //文件拖拽
    public function upload(Request $request){
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $photo = $request->file;
            
            $store_result = $photo->store('upload');
            //return $this->success(['msg'=>'上传成功','data'=>env('UPLOADS_URL').$store_result]);
            //return json_encode(['code'=>0,'msg'=>'上传成功','data'=>env('UPLOADS_URL').$store_result]);
            return $this->success('上传成功',env('UPLOADS_URL').$store_result);
        }
            return $this->error('上传失败');
    }
    //列表展示
    public function index(){
        $res=Admin::orderBy('admin_id','desc')->paginate(3);
        if(request()->ajax()){
            return view('admin/admin/ajaxpage',['res'=>$res,'query'=>request()->all()]);
        }
        return view('admin.admin.index',['res'=>$res]);
    }
    //修改展示
    public function edit($id){
        $res=Admin::where('admin_id',$id)->first();
        return view('admin.admin.edit',['res'=>$res]);
    }
    //执行修改
    public function updata(StoreAdminPost $request,$id){
        $post = request()->except('_token');
        //dd($post);
        $data=Admin::where('admin_id',$id)->update($post);
        if($data){
            return redirect('/admin');
        }
    }
    //删除
    public function destroy($id){
       
        $res=Admin::destroy($id);
        if(request()->ajax()){
            return $this->success('删除成功!');
        }
        if($res){
            return redirect('/admin');
        }

    }
    //退出登录
    public function loginout()
    {
       request()->session()->flush('admin');
       
        
    }


}
