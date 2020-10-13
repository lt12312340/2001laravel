<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Goods;
use App\Models\Brand;
use App\Models\Category;
class CatController extends Controller
{
    //商品列表
    public function goodslist($id){
        // dd($_SERVER);  预定义常量
        $url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REDIRECT_URL'];
        // dd($url);
        $query = request()->all();
        $where=[];
        //按价格搜索
        if(isset($query['price'])){
            $price_array = explode('元',$query['price']);
            $price_array = explode('-',$price_array[0]);
            $where[]=[
                'goods_price','>',$price_array[0]
            ];
            if(isset($price_array[1])){
                $where[]=[
                    'goods_price','<',$price_array[1]
                ];
            }
            //dd($price_array);
        }

        //按品牌搜索
        if(isset($query['brand_id'])){
            $where[]=[
                'brand_id','=',$query['brand_id']
            ];
        }
        //分类名称
        // dd($id);
        $catename = Category::select('cate_name')->find($id)->toArray()??[];
        // dd($catename);
        $cate = Category::get();
        $cate_id = $this->cateid($cate,$id); //获取该分类下的分类id
        // dump($cate_id);
        $cate_id = array_unique($cate_id);
        $brand_id = Goods::select('brand_id')->whereIn('cate_id',$cate_id)->orderBy('goods_id','desc')->get()->toArray()??[];
        // dump($brand_id);
        $brand_id = array_values($brand_id);
        // dd($brand_id);
        $count = count($brand_id);
        // dd($count);
        if($count != 0){
            for($i=0; $i<$count; $i++){
                $brandid[] = $brand_id[$i]['brand_id'];
            }
            $brandid = array_unique($brandid);
        }else{
            $brandid = [];
        }
        //品牌logo
        // dump($brandid);
        $brand_logo = Brand::select('brand_id','brand_logo','brand_name')->whereIn('brand_id',$brandid)->get();
        // dd($brand_logo);
        //根据分类查询商品
        $goods = Goods::where($where)->where('is_up',1)->whereIn('cate_id',$cate_id)->paginate(10);
        // dd($goods);

        //根据商品查询商品最大价格,计算价格阶段
        $goods_price = Goods::where('is_up',1)->where('cate_id',$cate_id)->max('goods_price');
        // dd($goods_price);
        $price = $this->getPrice($goods_price);
        return view('index.list',['brand_logo'=>$brand_logo,'catename'=>$catename['cate_name'],'goods'=>$goods,'price'=>$price,'query'=>$query,'url'=>$url]);
    }

    //当前分类下所有分类id
    public function cateid($data,$pid=0){
        static $newArray=[];
        $newArray[] = $pid;
        foreach($data as $k => $v){
            if($v['pid']==$pid){
                $newarray[] = $v->cate_id;
                $this->cateid($data,$v['cate_id']);
            }
        }
        return $newArray;
    }

    //获取价格阶段
    public function getPrice($goods_price){
        $length = strlen($goods_price);
        // dd($length);
        $format = '1'.str_repeat(0,$length-1);
        // dd($format);
        $maxprice = substr($goods_price,0,1);
        $maxprice = $maxprice*$format;
        // dd($maxprice);
        //价格阶段
        $price=[];
        $avgprice = $maxprice/5;
        for($i=0,$j=1; $i<$maxprice;$i++,$j++){
            $price[] = $i.'-'.$avgprice*$j.'元';
            $i=$avgprice*$j-1;
        }
        $price[]=$maxprice.'元以上';
        return $price;
    }
}
