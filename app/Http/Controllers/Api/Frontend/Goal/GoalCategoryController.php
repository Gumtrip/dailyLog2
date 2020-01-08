<?php

namespace App\Http\Controllers\Api\Frontend\Goal;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Models\Goal\GoalCategory;
use App\Http\Requests\Frontend\Goal\GoalCategoryRequest;
use App\Transformers\Frontend\Goal\GoalCategoryTransformer;
class GoalCategoryController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    public function index(GoalCategory $goalCategory){
        $query = $goalCategory->query();
//        $query->where('user_id',$this->user->id);
        $goalCategories = $query->paginate(config('app.pagination'));
        return $this->response->paginator($goalCategories,new GoalCategoryTransformer());
    }


    public function show(Request $request,GoalCategory $goalCategory){
        return $this->response->item($goalCategory,new GoalCategoryTransformer());
    }

    public function store(GoalCategoryRequest $categoryRequest ,GoalCategory $goalCategory){
        $goalCategory->fill($categoryRequest->all());
        $goalCategory->save();
        return $this->response->item($goalCategory,new GoalCategoryTransformer())->setStatusCode(201);
    }

    public function update(Request $request,GoalCategory $goalCategory){
        $data = $request->all();
        $goalCategory->update($data);
        return $this->response->item($goalCategory,new GoalCategoryTransformer());

    }

    public function destroy(Request $request,GoalCategory $goalCategory){
        $goalCategory->delete();
        return $this->response->noContent();
    }
}
