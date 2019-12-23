<?php


namespace App\Services;

use Storage;
use File;
use Log;

class ImageHandleService
{
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];

    /** 移动上传的图片到特定文件夹
     * @param $file
     * @param $folder
     * @param $id
     * @return array|bool
     */


    public function save($file, $folder = null, $id = null)
    {
        if ($folder && $id) {
            $folder_name = Storage::url($folder . '/' . $id);
            $upload_path = public_path($folder_name);
        } else {
            $folder_name = "/uploads/images/" . date("Ym", time()) . '/' . date("d", time());
            $upload_path = public_path($folder_name);
        }
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        $filename = $file->getClientOriginalName();
//            $filename = time() . '_' . Str::random(10) . '.' . $extension;

        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $file->move($upload_path, $filename);

        return [
            'full_path' => config('app.url') . "$folder_name/$filename",
            'path' => "$folder_name/$filename",
            'name' => $file->getClientOriginalName()
        ];
    }

    /** 移动本地图片
     * @param $image
     * @param $folder
     * @param $id
     * @return string
     */

    public function moveFile($image, $folder, $id)
    {
        $filesRoot = config('filesystems.disks.public.root');
        $dir = $folder . '/' . $id;
        if (!File::isDirectory($filesRoot . '/' . $dir)) {
            File::makeDirectory($filesRoot . '/' . $dir, 0755);
        }
        $file = public_path($image);//旧图全路径
        $fileBaseName = pathinfo($file, PATHINFO_BASENAME);
        $path = $dir . '/' . $fileBaseName;//新图全路径
        $fullPath = $filesRoot . '/' . $path;//新图全路径
        if (File::exists($file)) {
//            File::copy($file, $fullPath);
            File::move($file, $fullPath);
            File::chmod($fullPath, 0755);
            return Storage::url($path);
        } else {
            return null;
        }
    }

    /** 匹配图片
     * @param $content
     * @return mixed
     */
    public function matchImages($content)
    {
        $pattern = '/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.jpeg|\.png]))[\'|\"].*?[\/]?>/i';
        preg_match_all($pattern, $content, $matches);
        return $matches;
    }


    /** 移动图片并返回新路径
     * @param $image
     * @param $folder
     * @param $id
     * @return mixed
     */

    public function imageRealPath($image)
    {
        return trim(str_replace(config('app.url'), '', $image));//获取图片真实路径;
    }

    /** 富文本图片路径处理，返回图片处理后的内容
     * @param $content
     * @param $matches
     * @param $folder
     * @param $id
     * @return mixed
     */

    public function textAreaHandle($content, $matches, $folder, $id)
    {
        foreach ($matches[1] as $image) {
            $realPath = $this->imageRealPath($image);
            $path = $this->moveFile($realPath, $folder, $id);
            //这里很笨，直接遍历整个content 然后替换掉image
            //图片多后者富文本内容多，会有效率问题
            //TODO 找更好的方法一次替换，而不是通过遍历替换
            if ($path) {//如果图片存在，则移动，因为有可以能图片是第三方的！
                $content = str_replace($image, ($path), $content);
            }
        }
        return $content;

    }

}
