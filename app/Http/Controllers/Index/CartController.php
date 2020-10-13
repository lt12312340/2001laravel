<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Goods;
use App\Models\Products;
use App\Models\Cart;
use App\Models\Goods_attr;
class CartController extends Controller
{
    public function addcart(Request $request){
        //判断用户是否登录 没登录跳登录页面
        $user = $request->session()->get('user');
        // dd($user);
        if(!$user){
            return $this->error('请先登录');
        }

        $goods_id= $request->goods_id;
        $buy_number = $request->buy_number;
        $goods_attr_id = $request->goods_attr_id;
        
        //判断商品id 购买数量 是否缺少参数
        if(!$goods_id || !$buy_number){
            return $this->JsonResponse('1003','缺少参数');
        }

        //根据商品id 判断商品是否上下架  如果下架提示商品已下架
        $goods = Goods::select('goods_id','goods_name','goods_price','is_up','goods_num')->find($goods_id);
        // dd($goods);
        if($goods->is_up==2){
            return $this->JsonResponse('1004','商品已下架');
        }

        //判断规格是否存在，查询product的库存 购买数量大于库存  提示库存不足
        //如果没有规格查询goods的库存 购买数量大于库存  提示库存不足
        if($goods_attr_id){
            $goods_attr_id = implode('|',$goods_attr_id); //imploade 将数组用|分割成字符串
            // dump($goods_attr_id);

            $product = Products::select('product_id','product_number','product_sn')->where('goods_id',$goods_id)->where('goods_attr',$goods_attr_id)->first();
            // dd($product);
            if($product->product_number<$buy_number){
                return $this->JsonResponse('1005','商品库存不足');
            }
        }else{
            if($goods->goods_num<$buy_number){
                return $this->JsonResponse('1005','商品库存不足');
            }
        }

        //根据当前用户id ，商品id和规格判断购物车是否有次商品  没有添加入库  有更新购买数量
        //购买数量大于库存提示 把购物车数量改为最大库存 更新
        $cart = Cart::where(['user_id'=>$user->user_id,'goods_id'=>$goods_id,'goods_attr_id'=>$goods_attr_id])->first();
        // dd($cart);
        if($cart){
            //更新购买数量
            $buy_number = $cart->buy_number+$buy_number;
            if($goods_attr_id){
                //规格查询
                if($product->product_number<$buy_number){
                    $buy_number = $product->product_number;
                }
            }else{
                if($goods->goods_num<$buy_number){
                    $buy_number = $goods->goods_num;
                }
            }
            $res = Cart::where('rec_id',$cart->rec_id)->update(['buy_number'=>$buy_number]);
        }else{
            //添加购物车
            $data = [
                'user_id'=>$user->user_id,
                'product_id'=>$product->product_id??0,
                'buy_number'=>$buy_number,
                'goods_attr_id'=>$goods_attr_id??'',
                'goods_sn'=>$product->product_sn
            ];
            $goods = $goods?$goods->toArray():[];
            unset($goods['is_up']);
            unset($goods['goods_num']);
            $data = array_merge($data,$goods);
            // dd($data);
            $res = Cart::insert($data);
        }
        if($res){
            return $this->success("加入购物车成功");
        }

        
    }

    //购物车列表
    public function cart(){

        $user = session('user');
        if(!$user){
            return redirect('/login');
        }
        $user_id = $user->user_id;
        
        $cart = Cart::select('cart.*','goods.goods_img')->leftjoin('goods','cart.goods_id','=','goods.goods_id')->where('user_id',$user_id)->get();
        // $cart =$cart?$cart->toArray():[];
        // dd($cart);
        foreach($cart as $key => $val){
            if($val->goods_attr_id){
                // $goods_attr_id = explode('|',$val->goods_attr_id);
                $product_number = Cart::select('product_number')->leftjoin('products','cart.goods_attr_id','=','products.goods_attr')->where('rec_id',$val->rec_id)->first();
                $product_number = $product_number?$product_number->toArray():[];
                $number = '';
                foreach($product_number as $v){
                    $number = $v;
                }
                // dd($number);
            }else{
                $product_number = Cart::select('goods.goods_num')->leftjoin('goods','cart.goods_id','=','goods.goods_id')->where('rec_id',$val->rec_id)->first();
                $product_number = $product_number?$product_number->toArray():[];
                $number = '';
                foreach($product_number as $v){
                    $number = $v;
                }
                //dd($number);
            }
        }


        foreach($cart as $k=>$v){
            if($v->goods_attr_id){
                $goods_attr_id = explode('|',$v->goods_attr_id);
                $goods_attr = Goods_attr::select('attr_name','attr_value')->leftjoin('attribute','goods_attr.attr_id','=','attribute.attr_id')->whereIn('goods_attr_id',$goods_attr_id)->get();
                $cart[$k]['goods_attr'] = $goods_attr?$goods_attr->toArray():[];
            }
        }
        //dump($cart);
        return view('index.cart',['cart'=>$cart,'product_number'=>$number]);
    }

    //总价
    public function getcartprice(){
        $cart_id = request()->cart_id;
        // dd($cart_id);
        if(!$cart_id){
            return $this->success('ok',['total'=>0.00]);
        }
        $total = Cart::getprice($cart_id);
        // dd($total);
        return $this->success('ok',['total'=>$total]);
    }
}
