<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    //指定表名
    protected $table = 'goods';
    //指定主键
    protected $primaryKey = 'goods_id';
    //不自动添加时间 create_at update_at
    public $timestamps = false;
    //黑名单
    protected $guarded=[];

    public static function is_index_slice(){
        $index_slice = self::select('goods_img')->where('is_index_slice',1)->where('is_up',1)->take(3)->get();
        return $index_slice;
    }
}
