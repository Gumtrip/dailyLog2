<?php

namespace App\Observers\Article;

use App\Jobs\Article\CompressImg;
use App\Jobs\Article\DeleteImages;
use App\Jobs\Article\DeleteAndCleanDir;
use App\Jobs\Article\MoveImageFrTx;
use App\Models\Article\Article;
use App\Services\ImageHandleService;
use DB;
class ArticleObserver
{
    CONST FOLDER='article';

    /**
     * Handle the article "created" event.
     *
     * @param  \App\Models\Article\Article  $article
     * @return void
     */
    public function created(Article $article)
    {
        $uploadImageService = app (ImageHandleService::class);
        $path = $uploadImageService->moveFile($article->image,self::FOLDER,$article->id);
        $article->image = $path;
        CompressImg::dispatch($article);//压缩图片
        MoveImageFrTx::dispatch($article);//将富文本的图片移动到正确的位置
        DB::table('articles')->where('id',$article->id)->update(['image'=>$path]);
    }

    /**
     * Handle the article "updated" event.
     *
     * @param  \App\Models\Article\Article  $article
     * @return void
     */
    public function updated(Article $article)
    {
        if($article->isDirty('image')){
            //压缩新图
            CompressImg::dispatch($article);
            //删除旧图
            DeleteImages::dispatch($article);
        }

    }

    /**
     * Handle the article "deleted" event.
     *
     * @param  \App\Models\Article\Article  $article
     * @return void
     */
    public function deleted(Article $article)
    {
        DeleteAndCleanDir::dispatch($article);
    }

    /**
     * Handle the article "restored" event.
     *
     * @param  \App\Models\Article\Article  $article
     * @return void
     */
    public function restored(Article $article)
    {
        //
    }

    /**
     * Handle the article "force deleted" event.
     *
     * @param  \App\Models\Article\Article  $article
     * @return void
     */
    public function forceDeleted(Article $article)
    {
        //
    }
}
