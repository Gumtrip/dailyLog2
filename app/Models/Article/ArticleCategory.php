<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class ArticleCategory extends Model
{
    use NodeTrait;
    protected $fillable=['title'];
}
