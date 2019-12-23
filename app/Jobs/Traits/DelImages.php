<?php


namespace App\Jobs\Traits;


use File;

trait DelImages
{
    function deleteHandle($image){//这里不用Storage::disk(self::DISKS)->exists($image)判断
        if(File::exists($image)){//因为Storage::disk(self::DISKS)会在路径前面加storage
            File::delete($image);//数据库的值是带storage
        }
    }
}
