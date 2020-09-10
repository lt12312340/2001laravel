<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //指定表名
    protected $table = 'brand';
    //指定主键
    protected $primaryKey = 'brand_id';
    //不自动添加时间 create_at update_at
    //public $timestamps = false;
    //黑名单
    protected $guarded=[];
}
