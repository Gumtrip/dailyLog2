<?php

namespace App\Jobs\Article;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Article\Article;
use App\Jobs\Traits\DelAndCleanDir;
class DeleteAndCleanDir
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,DelAndCleanDir;

    protected $path;
    CONST FOLDER = 'article';

    /** 清空文件所在的文件夹并且删除文件夹
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        $filesRoot = config('filesystems.disks.public.root') ;
        $dir = self::FOLDER . '/' . $article->id;
        $this->path = $filesRoot.'/'.$dir;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->DelDirHandle($this->path);

    }
}
