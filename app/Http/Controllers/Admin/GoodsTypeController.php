<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoodsType;
use App\Models\Attribute;
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
            return view('admin/goods_type/indexpage',['goods_type'=>$goods_type,'cat_name'=>$cat_name]);
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

    // 即点即改
    public function check_name(){
        $value = request()->value;
        if(!$value){
            return $this->error('值不能为空');
        }
        $cat_id = request()->cat_id;
        $field = request()->field;
        //echo $value.$brand_id.$field;
        $goods_type = GoodsType::where('cat_id',$cat_id)->update([$field=>$value]);
        if($goods_type!==false){
            echo 0;
        }else{
            //echo json_encode(['code'=>'00000','msg'=>'ok']);
            echo 'no';
        }
    }

    // 对错号即点即改
    public function check_typeshows(){
        // 接值
        $cat_id=request()->cat_id;
        
        $_field=request()->_field;
        $data[$_field]=request()->is_show==1?2:1;
        //return $data[$_field];
        // dd($_value);
        $res=GoodsType::where(['cat_id'=>$cat_id])->update($data);
        // dump($res);
        if($res){
            return json_encode(['code'=>0,'msg'=>'ok','data'=>$data[$_field]]);
        }else{
            return json_encode(['code'=>-1,'msg'=>'no']);
        }
    }

    // 修改页面
    public function edit($id)
    {
        $goods_type=GoodsType::where('cat_id',$id)->first();
        return view('admin/goods_type/edit',['goods_type'=>$goods_type]);
    }

    //执行修改
    public function update(Request $request, $id)
    {
        $goods_type = $request -> except('_token');
        //dd($role);
        $res = GoodsType::where('cat_id',$id)->update($goods_type);
        // dd($res);
        if($res){
            return redirect('/goods_type/index');
        }

    }
    //商品属性列表
    public function attrshow($id){
        $attribute = GoodsType::leftjoin('attribute','goods_type.cat_id','=','attribute.cat_id')->where('attribute.cat_id',$id)->get();
        //dd($attribute); 
        return view('admin.goods_type.attrshow',['attribute'=>$attribute,'cat_id'=>$id]);
    }
}
