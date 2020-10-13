<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //指定表名
    protected $table = 'cart';
    //指定主键
    protected $primaryKey = 'rec_id';
    //不自动添加时间 create_at update_at
    public $timestamps = false;
    //黑名单
    protected $guarded=[];

    public static function getprice($cart_id){
        if(is_array($cart_id)){
            $cart_id = implode(',',$cart_id);
        }
        
        //dd($cart_id);
        $total = \DB::select("select sum(buy_number*goods_price) as total from cart where rec_id in($cart_id)");
        
        $total = $total?$total[0]->total:0;
        return $total;
    } 
}
