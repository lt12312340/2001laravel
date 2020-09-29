<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Goods;
use App\Models\Category;
class IndexController extends Controller
{
    public function index(Request $request){
        //首页幻灯片读取
        // Redis::flushall();
        $slice=Redis::get('slice');
        if(!$slice){
            echo "Db==";
            $slice=Goods::select('goods_id','goods_img')->orderBy('goods_id','desc')->limit(3)->get();
            $slice=serialize($slice);
            Redis::setex('slice',24*60*60,$slice);
        }
        $slice=unserialize($slice);
        // dd($slice);

        //左侧菜单
        $category = Category::get();
        // dd($category);
        $category = $this->createTree($category);
        // dd($category);
        $category = json_encode($category);
        $category = json_decode($category,true);
        // dd($category);
        return view('index/index',['slice'=>$slice,'category'=>$category]);
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


    //购物车
    public function cart(){
        return view('index.cart');
    }
}
