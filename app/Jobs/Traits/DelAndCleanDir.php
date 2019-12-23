<?php


namespace App\Jobs\Traits;


use File;
use Log;

trait DelAndCleanDir
{
    public function DelDirHandle($dir)
    {
        if(File::isDirectory($dir)){//使用队列的时候，它的根目录变成了项目的根目录了
            File::cleanDirectory($dir);//使用sudo php artisan horizon 的话，就会删除整个项目目录
            File::deleteDirectory($dir);//所以必须检测文件是否存在，不然会清空项目文件夹
        }else{
            Log::warning('【'.$dir.'】文件不存在或文件夹不存在');
        }
    }

}
