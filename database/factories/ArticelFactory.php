<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Article\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title'=>$faker->word,
        'category_id'=>$faker->randomDigitNotNull,
        'intro'=>$faker->sentence,
        'desc'=>$faker->text,
        'created_at'=>$faker->dateTime,
        'updated_at'=>$faker->dateTime,
    ];
});
