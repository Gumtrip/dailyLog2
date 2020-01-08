<?php

namespace App\Http\Controllers\Api\Frontend\Goal;

use App\Http\Requests\Frontend\Goal\GoalLogRequest;
use App\Http\Controllers\Api\Controller;
use App\Models\Goal\GoalLog;
use App\Transformers\Frontend\Goal\GoalLogTransformer;
class GoalLogController extends Controller
{
    public function index(GoalLogRequest $request){
        $goalId =$request->goalId;
        $goalLogs = GoalLog::where('goal_id',$goalId)->paginate(config('app.pagination'));
        return $this->response->paginator($goalLogs,new GoalLogTransformer);
    }
}
