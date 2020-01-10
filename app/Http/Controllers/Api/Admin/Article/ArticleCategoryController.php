<?php

namespace App\Http\Controllers\Api\Admin\Article;

use App\Http\Requests\Admin\BackendRequest as Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleCategoryResource;
use App\Models\Article\ArticleCategory;
use App\Http\Requests\Admin\Article\ArticleCategoryRequest;

class ArticleCategoryController extends Controller
{
    public function index(Request $request,ArticleCategory $articleCategory){
        $categories = $articleCategory->orderBy('id','desc')->paginate(config('app.page_size'));
        return ArticleCategoryResource::collection($categories);
    }

    public function showTree(Request $request, ArticleCategory $articleCategory){
        $depth = $request->depth;
        $id = $request->id;
        $categories = $articleCategory->withDepth()->when($depth, function ($query) use ($depth) {
            $depth = $depth <= 2 ? $depth : 2;
            return $query->having('depth', '<=', $depth);
        })->when($id,function($query) use($id){
            //在分类编辑页不能显示自己以及自己的子类
            $descendantsAndSelf = ArticleCategory::descendantsAndSelf($id);
            return $query->whereNotIn('id',$descendantsAndSelf->pluck('id'));
        })->get()->toTree();
        return new ArticleCategoryResource($categories);
    }


    public function store(ArticleCategoryRequest $request,ArticleCategory $articleCategory){
        $parentId = $request->parent_id;
        if ($parentId && $parentCategory = ArticleCategory::find($parentId)) {
            $articleCategory = $parentCategory->children()->create($request->all());
        } else {
            $articleCategory->fill($request->all());
            $articleCategory->makeRoot()->save();
        }
        return new ArticleCategoryResource($articleCategory);
    }
    public function show(Request $request,ArticleCategory $articleCategory){
        return new ArticleCategoryResource($articleCategory);
    }
    public function update(ArticleCategoryRequest $request,ArticleCategory $articleCategory){
        $parentId = $request->parent_id;
        if ($parentId && $parentCategory = ArticleCategory::find($parentId)) {
            $articleCategory->fill($request->all());
            $articleCategory->appendToNode($parentCategory)->save();
        } else {
            $articleCategory->makeRoot()->update($request->all());
        }
        $articleCategory::fixTree();
        return new ArticleCategoryResource($articleCategory);
    }
    public function destroy(Request $request,ArticleCategory $articleCategory){
        $articleCategory->delete();
        return response(null,204);
    }
}
