<?php

namespace App\Jobs\Article;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Article\Article;
use App\Jobs\Traits\DelImages;

class DeleteImages
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,DelImages;

    protected $image;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        $image = $article->getOriginal('image');
        $this->image = public_path($image);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $imageSizes = config('app.thumb_img');
        $this->deleteHandle($this->image);
        foreach($imageSizes as $size=>$thumb) {
            $this->deleteHandle(getThumbName($this->image,$thumb['name']));
        }
    }

}
