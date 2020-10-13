<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_address;
use App\Models\Region;
use App\Models\Cart;
use App\Models\Goods;
use App\Models\Goods_attr;
use App\Models\Order_goods;
use App\Models\Order_info;
use DB;
class OrderController extends Controller
{
    //判断用户有没有收货地址  没有弹出填写收货地址框
    public function confirmorder(Request $request){
        $rec_id = $request->rec_id;
        
        $rec_id = explode(',',$rec_id);
        // dd($rec_id);
        $user = session('user');
        // dd($user->user_id);
        //判断用户有没有收货地址  没有弹出填写收货地址框  有不就弹框然后展示
        $address = User_address::where('user_id',$user->user_id)->get();
        $address = $address?$address->toArray():[];
        // if($address){
        //     foreach($address as $k=>$v){
        //         $address[$k]['country'] = Region::where('region_id',$v['country'])->value('region_name');
        //         $address[$k]['province'] = Region::where('region_id',$v['province'])->value('region_name');
        //         $address[$k]['city'] = Region::where('region_id',$v['city'])->value('region_name');
        //         $address[$k]['district'] = Region::where('region_id',$v['district'])->value('region_name');
        //     }
        // }
        // dd($address);
        // $topaddress='';
        // if(!$address){
            $topaddress = Region::where('parent_id',0)->get();
            
        // }
        //dd($topaddress);

        //获取要下单的商品  从购物车的id获取
        $goods = Cart::select('cart.*','goods.goods_img')->leftjoin('goods','cart.goods_id','=','goods.goods_id')->whereIn('rec_id',$rec_id)->get();
        // dd($goods);
        foreach($goods as $k=>$v){
            if($v->goods_attr_id){
                $goods_attr_id = explode('|',$v->goods_attr_id);
                $goods_attr = Goods_attr::select('attr_name','attr_value')->leftjoin('attribute','goods_attr.attr_id','=','attribute.attr_id')->whereIn('goods_attr_id',$goods_attr_id)->get();
                $goods[$k]['goods_attr'] = $goods_attr?$goods_attr->toArray():[];
            }
        }
        return view('index/confirmorder',['address'=>$address,'topaddress'=>$topaddress,'goods'=>$goods]);
    }

    //获取子地区
    public function getsonaddress(Request $request){
        $region_id = $request->region_id;
        // dd($region_id);
        $address = Region::where('parent_id',$region_id)->get();
        // dd($address);
        return $this->success('ok',['data'=>$address]);
    }

    //用户收货地址添加 展示
    public function useraddressadd(Request $request){
        $useraddress = $request->all();
        $useraddress['user_id'] = session('user')->user_id;
        // dd($useraddress);
        
        $res = User_address::create($useraddress);

        if($request->ajax()){
            $address = User_address::where('user_id',session('user')->user_id)->get();
            return view('index/useraddress',['address'=>$address]);
        }
    }

    //订单
    public function order(Request $request){
        DB::beginTransaction();
        try {
        $data = $request->except('_token');
        $rec_id = $data['rec_id'];
        $data['order_sn'] = $this->createOrderSn();
        $data['user_id'] = session('user')->user_id;
        if($data['address_id']){
            $useraddress = User_address::where('address_id',$data['address_id'])->first();
            $useraddress = $useraddress?$useraddress->toArray():[];
        }
        $data = array_merge($data,$useraddress);
        $pay_name = ['1'=>'微信','2'=>'支付宝','3'=>'货到付款'];
        $data['pay_name'] = $pay_name[$data['pay_type']];
        $data['goods_price'] = Cart::getprice($data['rec_id']);
        $data['order_price'] = $data['goods_price'];
        $data['addtime'] = time();
        unset($data['address_id']);
        unset($data['is_default']);
        unset($data['rec_id']);
        unset($data['address_name']);
        // dd($data);

        //添加入库订单表 获取订单id
        $order_id = Order_info::insertGetId($data);
        // dd($order_id);

        //订单商品表入库
        
        if(is_string($rec_id)){
            $rec_id = explode(',',$rec_id);
        }
        $goods = Cart::select('cart.*','goods.goods_img')->leftjoin('goods','cart.goods_id','=','goods.goods_id')->whereIn('rec_id',$rec_id)->get();
        $goods = $goods?$goods->toArray():[];
        
        foreach($goods as $k=>$v){
            $goods[$k]['order_id'] = $order_id;
            unset($goods[$k]['rec_id']);
            unset($goods[$k]['user_id']);
        }
        //dd($goods);
        $res = Order_goods::insert($goods);
        DB::commit();
        if($res){
            dump('拿下！');
            // return redirect('/pay');
        }
        } catch (\Throwable $e) {
            dump($e->getMessage());
            DB::rollBack();
        }   
    }

    //生成货号
    public function createOrderSn(){
        $order_sn =  date('YmdHis').rand(1000,9999);
        if($this->isHaveOrdersn($order_sn)){
            $this->createOrderSn();
        }
        return $order_sn;
    }

    //判断货号是否重复
    public function isHaveOrdersn($order_sn){
        return Order_info::where('order_sn',$order_sn)->count();
    }

    
    
}
