<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Goods;
use App\Models\Goods_type;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Goods_attr;
use App\Models\Products;
use App\Models\Goods_gallery;
use DB;
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
        $goods_type = Goods_type::get();
        $brand = Brand::get();
        $cate = Category::get();
        return view("admin.goods.create",compact("brand","cate","goods_type"));
    }

    //单图片
    public function upload(Request $request){
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $photo = $request->file;

            $store_result = $photo->store('upload');
            //return $this->success(['msg'=>'上传成功','data'=>env('UPLOADS_URL').$store_result]);
            //return json_encode(['code'=>0,'msg'=>'上传成功','data'=>['src'=>env('UPLOADS_URL').$store_result]]);
            // dd(env('UPLOADS_URL').$store_result);
            return $this->success('上传成功',env('UPLOADS_URL').$store_result);
        }
            return $this->error('上传失败');
    }


    public function getattr(){
        $cat_id = request()->cat_id;
        // dd($cat_id);
        $attr = Attribute::where('cat_id',$cat_id)->get();
        // dd($attr);
        return view('admin/goods/type_attr',['attr'=>$attr]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // dd($request->all());
            $attr_id = $request->attr_id??[];
            $attr_value = $request->attr_value??[];
            //  dd($attr_value);
            $attr_price = $request->attr_price??[];
            $goods_imgs = $request->goods_imgs??[];
            
            $arr = $request->except("_token","cat_id","attr_id","attr_value","attr_price","goods_imgs");
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
            // if($arr["goods_imgs"]){
            //     $arr["goods_imgs"] = implode("|",$arr["goods_imgs"]);
            // }
            $goods_id = Goods::insertGetId($arr);
            
            //商品属性入库
            if(count($attr_id) && count($attr_value)){
                $goods_attr = [];
                for($i=0; $i<count($attr_id); $i++){
                    $goods_attr[]=[
                        'goods_id' => $goods_id,
                        'attr_id' => $attr_id[$i],
                        'attr_value' => $attr_value[$i],
                        'attr_price' => $attr_price[$i],
                    ];
                }
                // dd($goods_attr);
                Goods_attr::insert($goods_attr);
            }

            //商品相册入库
            if(count($goods_imgs)){
                $goods_imgs_data=[];
                foreach($goods_imgs as $v){
                    $goods_imgs_data[]=[
                        'goods_id' => $goods_id,
                        'img_url' => $v,
                    ];
                }
                Goods_gallery::insert($goods_imgs_data);
            }

            DB::commit();
            //判断有没有规格
            $goods_specs = $this->GoodsSpecs($goods_id);
            // dump($goods_specs);

            if(count($goods_specs)){
                $new_goods_specs = [];
                foreach($goods_specs as $v){
                    $new_goods_specs['attr_name'][$v['attr_id']] = $v['attr_name'];
                    $new_goods_specs['attr_values'][$v['attr_id']][$v['goods_attr_id']] = $v['attr_value'];
                }
                // dump($new_goods_specs);
                $goods = Goods::select('goods_id','goods_name')->where('goods_id',$goods_id)->first();
                return view('admin.goods.product',['goods_specs'=>$new_goods_specs,'goods'=>$goods]);
            }

            
            if($goods_id){
                return redirect("/goods/index");
            }else{
                return redirect("/goods/create");
            }

        } catch (\Throwable $th) {
            dump($th->getMessage());
            DB::rollBack();
        }

    }

    //货品入库
    public function product(Request $request){
        $post  = $request->except('_token');
        // dd($post);
        if(count($post['attr'])){
            $attr = $post['attr'];
            // dump($attr);
            $firstKey = array_key_first($attr);//获取数组第一个key
            // dd($firstKey);
            $count = count($attr[$firstKey]);
            // dd($count);
            for($i=0;$i<$count;$i++){
                $new_attr[] = array_column($attr,$i);
            }
            // dd($new_attr);
            $produnct = [];
            foreach($new_attr as $k => $v){
                $product[] = [
                    'goods_id' => $post['goods_id'],
                    'goods_attr' => implode('|',$v),
                    'product_sn' =>$post['product_sn'][$k]?:$this->createProductSn(),
                    'product_number' => $post['product_number'][$k]
                ];
            }
            // dd($product);
            $res = Products::insert($product);
            if($res){
                return redirect("/goods/index");
            }

        }
    }

    //自动生成货号
    public function createProductSn(){
        return "shop".date("YmdHis").rand('1000','9999');
    }

    //判断有没有规格
    public function GoodsSpecs($goods_id){
        $goods_attr = Goods_attr::select('goods_attr_id','goods_attr.attr_id','attribute.attr_name','goods_attr.attr_value')
        ->leftjoin('attribute','goods_attr.attr_id','=','attribute.attr_id')
        ->where('goods_id',$goods_id)
        ->where('attr_type',2)
        ->get();
        // dd($goods_attr->toArray());
        return $goods_attr?$goods_attr->toArray():[];
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
