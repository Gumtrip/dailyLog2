<?php

namespace App\Http\Controllers\Api\Frontend\Goal;

use App\Http\Resources\Goal\GoalCategoryResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Goal\GoalCategory;
use App\Http\Requests\Frontend\Goal\GoalCategoryRequest;
class GoalCategoryController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function index(GoalCategory $goalCategory){
        $categories = $goalCategory->orderBy('id','desc')->paginate();
        return GoalCategoryResource::collection($categories);
    }

    public function showTree(Request $request, GoalCategory $goalCategory){
        $depth = $request->depth;
        $id = $request->id;
        $categories = $goalCategory->withDepth()->when($depth, function ($query) use ($depth) {
            $depth = $depth <= 2 ? $depth : 2;
            return $query->having('depth', '<=', $depth);
        })->when($id,function($query) use($id){
            //在分类编辑页不能显示自己以及自己的子类
            $descendantsAndSelf = GoalCategory::descendantsAndSelf($id);
            return $query->whereNotIn('id',$descendantsAndSelf->pluck('id'));
        })->get()->toTree();
        return new GoalCategoryResource($categories);
    }


    public function show(Request $request,GoalCategory $goalCategory){

        return new GoalCategoryResource($goalCategory);
    }

    public function store(GoalCategoryRequest $categoryRequest ,GoalCategory $goalCategory){
        $parentId = $categoryRequest->parent_id;
        if ($parentId && $parentCategory = GoalCategory::find($parentId)) {
            $goalCategory->fill($categoryRequest->all());
            $goalCategory->appendToNode($parentCategory);
            $goalCategory->user()->associate($this->user->id)->save();
        } else {
            $goalCategory->fill($categoryRequest->all());
            $goalCategory->user()->associate($this->user->id);
            $goalCategory->makeRoot()->save();
        }
        return response(null,201);
    }

    public function update(GoalCategoryRequest $request,GoalCategory $goalCategory){
        $parentId = $request->parent_id;
        if ($parentId && $parentCategory = GoalCategory::find($parentId)) {
            $goalCategory->fill($request->all());
            $goalCategory->appendToNode($parentCategory)->save();
        } else {
            $goalCategory->makeRoot()->update($request->all());
        }
        $goalCategory::fixTree();
        return new GoalCategoryResource($goalCategory);

    }

    public function destroy(Request $request,GoalCategory $goalCategory){
        $goalCategory->delete();
        return response(null,204);
    }
}
