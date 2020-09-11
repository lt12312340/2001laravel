<?php
//文件上传
function upload($filename){
        $file=request()->file($filename);
        if($file->isValid()){
            $path=$file->store('uploads');
            return $path;
        }
    }

//无限极分类
function createTree($data,$parent_id=0,$level=0){
    if(!$data) return;

    static $newArray=[];

    foreach($data as $v){
        if($v->pid==$parent_id){
            $v->level=$level;
            $newArray[]=$v;
            createTree($data,$v->cate_id,$level+1);
        }
    }
    return $newArray;
    
} 