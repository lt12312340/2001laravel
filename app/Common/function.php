<?php

function upload($filename){
        $file=request()->file($filename);
        if($file->isValid()){
            $path=$file->store('uploads');
            return $path;
        }
    }

?> 