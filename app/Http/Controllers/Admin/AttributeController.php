<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Attribute;
use  App\Models\Goods_type;
use App\Http\Requests\StoreAttribute;
class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attr_name = request()->attr_name;
        $cat_id = request()->cat_id;
        // dump($attr_name);
        // dd($cat_id);
        $where = [];
        if($attr_name){
            $where[] = ['attr_name','like',"%$attr_name%"];
        }
        if($cat_id){
            $where[] = ['goods_type.cat_id','=',$cat_id];
        }
        // dd($where);
        $cat = Goods_type::get();
        // dd($cat);
        $attribute = Attribute::leftjoin('goods_type','attribute.cat_id','=','goods_type.cat_id')->where($where)->orderBy('attr_id','desc')->paginate(10);
        if(request()->ajax()){
            return view('admin/attribute/ajaxpage',['attribute'=>$attribute,'cat'=>$cat,'attr_name'=>$attr_name,'cat_id'=>$cat_id]);
        }
        return view('admin/attribute/index',['attribute'=>$attribute,'cat'=>$cat,'attr_name'=>$attr_name,'cat_id'=>$cat_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat = Goods_type::get();
        // dd($cat);
        return view('admin/attribute/create',['cat'=>$cat]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttribute $request)
    {
        $attribute = $request->except('_token');
        // dd($attribute);
        $res = Attribute::insert($attribute);
        // dd($res);
        if($res){
            return redirect('/attribute');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = Goods_type::get();
        $attribute = Attribute::where('attr_id',$id)->first();
        // dd($attribute);
        return view('admin/attribute/edit',['attribute'=>$attribute,'cat'=>$cat]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAttribute  $request, $id)
    {
        $attribute = $request->except('_token');
        // dd($attribute);
        $res = Attribute::where('attr_id',$id)->update($attribute);
        if($res!==false){
            return redirect('/attribute');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=0)
    {
        $id = request()->id?:$id;
        // dd($id);
        // return $id;
        if(!$id){
            return;
        }
        $res = Attribute::destroy($id);
        if(request()->ajax()){
            //dd($this->success('删除成功'));
            return $this->success('删除成功!');
        }
        if($res){
            return redirect('/attribute');
        }
    }

    public function check_name(Request $request){
        $value = request()->value;
        if(!$value){
            return $this->error('值不能为空');
        }
        $attr_id = request()->attr_id;
        $field = request()->field;
        $attribute = Attribute::where('attr_id',$attr_id)->update([$field=>$value]);
        // dd($attribute);
        if($attribute!==false){
            echo 0;
        }else{
            //echo json_encode(['code'=>'00000','msg'=>'ok']);
            echo 'no';
        }
    }
}
