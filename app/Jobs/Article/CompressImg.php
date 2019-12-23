<?php

namespace App\Jobs\Article;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\Traits\CompressImages;
use App\Models\Article\Article;
class CompressImg
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,CompressImages;
    protected $path;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {

        $this->path = $article->image;
    }

    /** TODO 始终无法解决 用任务无法写入的问题，删除也是
     *
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->compressHandle($this->path);

    }
}
