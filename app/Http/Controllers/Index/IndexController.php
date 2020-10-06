<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Goods;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Goods_gallery;
use App\Models\Goods_attr;
class IndexController extends Controller
{
    public function index(Request $request){
        //首页幻灯片读取
        // Redis::flushall();
        $slice=Redis::get('slice');
        if(!$slice){
            // echo "Db==";
            $slice=Goods::is_index_slice();
            // dd($slice);
            $slice=serialize($slice);
            Redis::setex('slice',24*60*60,$slice);
        }
        $slice=unserialize($slice);
        // dd($slice);

        //左侧菜单
        $category = Redis::get('category');
        if(!$category){
            $category = Category::get();
            // dd($category);
            $category = $this->createTree($category);
            // dd($category);
            $category = json_encode($category);
            $category = json_decode($category,true);
            $category=serialize($category);
            Redis::setex('category',24*60*60,$category);
        }
        $category=unserialize($category);

        //猜你喜欢
        $goods = Goods::select('goods_id','goods_name','goods_img','goods_price')->orderBy('goods_id','desc')->limit(6)->get();
        // dd($goods);
        
        return view('index/index',['slice'=>$slice,'category'=>$category,'goods'=>$goods]);
    }

    //左侧菜单
    public function createTree($data,$parent_id=0){
        if(!$data){
            return;
        } 

        $newArray=[];

        foreach($data as $v){
            if($v->pid==$parent_id){
                $newArray[]=$v;
                $child = $this->createTree($data,$v->cate_id);
                $v['child'] = $child;
            }
        }
        return $newArray;
        
    }

    //商品列表
    public function goodslist($id){
        // dd($cate_id);
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
        // dump($brandid);
        $brand_logo = Brand::select('brand_id','brand_logo')->whereIn('brand_id',$brandid)->get();
        // dd($brand_logo);
        
        return view('index.list',['brand_logo'=>$brand_logo,'catename'=>$catename['cate_name']]);
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


    //商品详情
    public function goodsinfo($goods_id){
        $goods = Goods::find($goods_id);
        $gallery = Goods_gallery::where('goods_id',$goods_id)->get();//相册
        // dd($gallery);
        // dd($goods);

        //基本属性
        $goods_attr_base = Goods_attr::select('goods_attr_id','goods_attr.attr_id','attribute.attr_name','goods_attr.attr_value')
        ->leftjoin('attribute','goods_attr.attr_id','=','attribute.attr_id')
        ->where('goods_id',$goods_id)
        ->where('attr_type',1)
        ->get()->toArray();
        // dd($goods_attr);

        //规格属性
        $goods_attr_specs = Goods_attr::select('goods_attr_id','goods_attr.attr_id','attribute.attr_name','goods_attr.attr_value')
        ->leftjoin('attribute','goods_attr.attr_id','=','attribute.attr_id')
        ->where('goods_id',$goods_id)
        ->where('attr_type',2)
        ->get()->toArray();
        // dump($goods_attr_specs);
        if($goods_attr_specs){
            foreach($goods_attr_specs as $k => $v){
                $new_goods_specs[$v['attr_id']]['attr_name'] = $v['attr_name'];
                $new_goods_specs[$v['attr_id']]['attr_values'][$v['goods_attr_id']] = $v['attr_value'];
            }
        }
        // dd($new_goods_specs);
        return view('index/goodsshow',['goods'=>$goods,'gallery'=>$gallery,'goods_attr_base'=>$goods_attr_base,'goods_attr_specs'=>$new_goods_specs]);

    }

    public function getattrprice(){
        $goods_attr_id = request()->goods_attr_id;
        $goods_id = request()->goods_id;
        // dd($goods_attr_id);
        $goods_attr_price = Goods_attr::whereIn('goods_attr_id',$goods_attr_id)->sum('attr_price');
        // dd($goods_attr_price);
        $goods_price = Goods::where('goods_id',$goods_id)->value('goods_price')+$goods_attr_price;
        // dd($goods_price);
        $goods_price = number_format($goods_price,2,".","");
        return $this->success('ok',['goods_price'=>$goods_price]);
    }

    //购物车
    public function cart(){
        return view('index.cart');
    }
}
