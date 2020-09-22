<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoodsType;
class GoodsTypeController extends Controller
{
    // 添加页面
    public function create(){
        return  view('admin.goods_type.create');
    }

    // 执行添加
    public function store(){
        $post=request()->except('_token');
        // dd($post);
        $goods_type=GoodsType::create($post);
        if($goods_type){
            return redirect('goods_type/index');
        }
    }

    // 列表页
    public function index(){
        $cat_name=request()->cat_name;
        $where=[];

        if($cat_name){
            $where[]=['cat_name','like',"%$cat_name%"];
        }

        $goods_type=GoodsType::where($where)->paginate(5);
        if(request()->ajax()){
            return view('admin/goods_type/indexpage',['goods_type'=>$goods_type,'query'=>request()->all()]);
        }
        return  view('admin.goods_type.index',['goods_type'=>$goods_type,'cat_name'=>$cat_name]);
    }

    // 单删
    public function destroy($cat_id=0)
    {
        $cat_id = request()->cat_id?:$cat_id;
        if(!$cat_id){
            return;
        }
        $res = GoodsType::destroy($cat_id);
        if(request()->ajax()){
            //dd($this->success('删除成功'));
            return $this->success('删除成功!');
        }
        if($res){
            return redirect('/index');
        }
    }
}
