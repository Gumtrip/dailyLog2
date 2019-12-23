<?php
if(!function_exists('getThumbName')){
    function getThumbName($file,$thumbName=null){
        if(!$thumbName)$thumbName = config('app.thumb_img.mid.name');
        $fileName = pathinfo($file,PATHINFO_FILENAME);
        $ext = pathinfo($file,PATHINFO_EXTENSION);
        $newFileName = $fileName.'-'.$thumbName.'.'.$ext;
        $dir = pathinfo($file,PATHINFO_DIRNAME);
        $fullName = $dir.'/'.$newFileName;
        return $fullName;
    }
}

