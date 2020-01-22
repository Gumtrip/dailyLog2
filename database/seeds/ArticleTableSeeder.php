<?php

use App\Models\Article\Article;
use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 防止内存耗尽的异常
        ini_set('memory_limit', -1);
        // 所有分类 ID 数组，如：[1,2,3,4]
        $user_ids = $category_ids = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];

        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        for ($i=0; $i < 5000; $i++) {

            $articles = factory(Article::class)
                ->times(1000)
                ->make()
                ->each(function ($article, $index)
                use ($user_ids, $category_ids, $faker)
                {
                    // 从用户 ID 数组中随机取出一个并赋值
                    $article->user_id = $faker->randomElement($user_ids);

                    // 话题分类，同上
                    $article->category_id = $faker->randomElement($category_ids);
                });

            // 将数据集合转换为数组，并插入到数据库中
            \DB::table('articles')->insert($articles->toArray());

            // 让我们知道插入数据的进度
            print("第 $i 批数据插入完成 \n");
        }

    }
}
