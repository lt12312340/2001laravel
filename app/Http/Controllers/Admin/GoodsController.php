<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Goods;
use App\Models\Category;
use Validator;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goods_name = request()->get("goods_name");
        $brand_id = request()->get("brand_id");
        $cate_id = request()->get("cate_id");
        $where = [];
        if($goods_name){
            $where[] = ["goods_name","like","%$goods_name%"];
        }
        if($brand_id){
            $where[] = ["goods.brand_id","like","%$brand_id%"];
        }
        if($cate_id){
            $where[] = ["goods.cate_id","like","%$cate_id%"];
        }
        $goods = Goods::leftjoin("brand","goods.brand_id","=","brand.brand_id")
                    ->join("category","goods.cate_id","=","category.cate_id")
                    ->where("is_del",1)
                    ->where($where)
                    ->orderBy("goods_id","desc")
                    ->paginate("3");
        // dd($goods);
        $brand = Brand::get();
        $cate = Category::get();
        if(request()->ajax()){
            return view("admin.goods.indexpage",compact("goods","goods_name","brand_id","cate_id"));
        }
        return view("admin.goods.index",compact("goods","goods_name","brand","brand_id","cate","cate_id"));

    }

    //即点即改
    public function checkge(Request $request){
        $arr = $request->all();
        // dd($arr);
        if($arr["field"]=="goods_name"){
            $goods = Goods::where("goods_name",$arr["value"])->first();
            if($goods){
                return $this->error('商品已存在');
            }
        }

        $res = Goods::where("goods_id",$arr["goods_id"])->update([$arr["field"]=>$arr["value"]]);
        if($res){
            echo "ok";
        }else{
            echo "no";
        }
    }

    //即点即改
    public function ajaxji(Request $request){
        $arr = $request->all();
        $filed = $arr["filed"];
        $status = $arr["status"]==1?2:1;
        // print_r($status);exit;
        $res = Goods::where("goods_id",$arr["goods_id"])->update([$filed=>$status]);
        if($res){
            $add = $arr["status"]==1?"×":"√";
            $message = [
                "status"=>"true",
                "code"=>"00000",
                "msg"=>$status,
                "result"=>$add
            ];
        }

        echo json_encode($message);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand = Brand::get();
        $cate = Category::get();
        return view("admin.goods.create",compact("brand","cate"));
    }

    //单图片
    public function upload(Request $request){
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $photo = $request->file;

            $store_result = $photo->store('upload');
            //return $this->success(['msg'=>'上传成功','data'=>env('UPLOADS_URL').$store_result]);
            //return json_encode(['code'=>0,'msg'=>'上传成功','data'=>env('UPLOADS_URL').$store_result]);
            // dd(env('UPLOADS_URL').$store_result);
            return $this->success('上传成功',env('UPLOADS_URL').$store_result);
        }
            return $this->error('上传失败');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arr = $request->except("_token");
        // dd($arr);
        $validator = Validator::make($arr,[
            'goods_name' => 'required|unique:goods',
            'goods_price' => 'required|integer',
            'goods_num' => 'required|integer',
            'goods_score' => 'required|integer',
            'goods_desc' => 'required',
        ],[
            "goods_name.required"=>"商品名称必填",
            "goods_name.unique"=>"商品名称已存在",
            "goods_price.required"=>"商品价格必填",
            "goods_price.integer"=>"商品价格必须为数字",
            "goods_num.required"=>"商品库存必填",
            "goods_num.integer"=>"商品库存必须为数字",
            "goods_score.required"=>"商品积分必填",
            "goods_score.integer"=>"商品积分必须为数字",
            "goods_desc.required"=>"商品简介必填",
        ]);
        if ($validator->fails()) {
            return redirect('goods/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        if($arr["goods_imgs"]){
            $arr["goods_imgs"] = implode("|",$arr["goods_imgs"]);
        }
        $res = Goods::create($arr);
        if($res){
            return redirect("/goods/index");
        }else{
            return redirect("/goods/create");
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
    public function edit($id=0)
    {
        $id = request()->all();
        $brand = Brand::get();
        $cate = Category::get();
        $goods = Goods::where("goods_id",$id)->first();
        return view("admin.goods.edit",compact("goods","brand","cate"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $arr = $request->except("_token");
        // dd($arr);
        $validator = Validator::make($arr,[
            'goods_name' => 'required',
            'goods_price' => 'required|integer',
            'goods_num' => 'required|integer',
            'goods_score' => 'required|integer',
            'goods_desc' => 'required',
        ],[
            "goods_name.required"=>"商品名称必填",
            "goods_price.required"=>"商品价格必填",
            "goods_price.integer"=>"商品价格必须为数字",
            "goods_num.required"=>"商品库存必填",
            "goods_num.integer"=>"商品库存必须为数字",
            "goods_score.required"=>"商品积分必填",
            "goods_score.integer"=>"商品积分必须为数字",
            "goods_desc.required"=>"商品简介必填",
        ]);
        if ($validator->fails()) {
            return redirect('goods/create')
                            ->withErrors($validator)
                            ->withInput();
        }
        if($arr["goods_imgs"]){
            $arr["goods_imgs"] = implode("|",$arr["goods_imgs"]);
        }
        $res = Goods::where("goods_id",$id)->update($arr);
        if($res){
            return redirect("/goods/index");
        }else{
            return redirect("/goods/index");
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
        //dd($id);
        if(!$id){
            return;
        }
        $res = Goods::where("goods_id",$id)->update(["is_del"=>0]);
        if(request()->ajax()){
            return $this->success('删除成功!');
        }
        if($res){
            return redirect('/goods/index');
        }
    }
}
