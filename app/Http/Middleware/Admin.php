<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Support\Facades\Route;
class Admin
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
        $res=$request->session()->get('admin');
        if(!$res){
            return redirect('/login');
        }

        //获取路由别名
        $name = Route::currentRouteName();
        // dd($name);
        // dump($name!='main');
        // dump($res->admin_id != 41);
        if($name!='main' && $res->admin_id != 41){
           // dd('执行了');
        //权限判断
        $priv = DB::select("select DISTINCT rm.menu_id,m.* from role_menu as rm inner join menu as m on rm.menu_id=m.menu_id inner join admin_role as ar on ar.role_id = rm.role_id where ar.admin_id='$res->admin_id' and m.function='$name'");
        //dd($priv);
        //  dd($priv);
    
        // dd($priv);
        if(!$priv){
            if(request()->ajax()){
                return response()->json(['code'=>'403','msg'=>'没有权限']);
            }
            //abort(403,'宁也配?');
            return redirect('/403');
        }
        
        }

        //查询左侧菜单
        //超级管理员获取所有菜单  supper
        if($res->admin_name == 'supper'){
            $privmenu = DB::select("select * from menu where is_show = 1");
        }else{
            $privmenu = DB::select("select DISTINCT rm.menu_id,m.* from role_menu as rm inner join menu as m on rm.menu_id=m.menu_id inner join admin_role as ar on ar.role_id = rm.role_id where m.is_show =1 and ar.admin_id='$res->admin_id'");
        }

        //控制左侧菜单的展示
        $privmenu = $this->createsontree($privmenu);
        // dd($privmenu);
        view()->share('priv',$privmenu);
        return $next($request);
    }

    public function createsontree($data,$partent_id=0){
        if(!$data){
            return;
        }
        $newarray = [];
        foreach($data as $k=>$v){
            if($v->parent_id==$partent_id){
                $newarray[$k] = $v;
                $newarray[$k]->son = $this->createsontree($data,$v->menu_id);
            }
        }
        return $newarray;
    }
}
