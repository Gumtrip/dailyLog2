<?php

namespace App\Jobs\Article;

use App\Models\Article\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\ImageHandleService;
use DB;

class MoveImageFrTx
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $article;
    const FOLDER = 'article';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $content = $this->article->desc;
        $imageHandleService = app(ImageHandleService::class);
        $matches = $imageHandleService->matchImages($content);
        if (isset($matches[1]) && $matches[1]) {
            $content = $imageHandleService->textAreaHandle($content, $matches, self::FOLDER, $this->article->id);
            if ($content) {
                DB::table('articles')->where('id', $this->article->id)->update(['desc' => $content]);
            }
        }

    }
}
