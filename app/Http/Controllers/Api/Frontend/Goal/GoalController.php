<?php

namespace App\Http\Controllers\Api\Frontend\Goal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Goal\Goal;
use App\Transformers\Frontend\Goal\GoalTransformer;
use App\Http\Requests\Frontend\Goal\GoalRequest;

class GoalController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    public function index(Request $request,Goal $goal){
        $query = $goal->query();
        $pageSize = $request->page_size??config('app.pagination');
        if($this->user){
            $query->where('user_id',$this->user->id);
        }else{
            $query->whereNull('user_id');
        }

        $goals = $query->orderBy('id','desc')->paginate($pageSize);
        return $this->response->paginator($goals,new GoalTransformer());
    }

    public function show(Request $request,Goal $goal){
        return $this->response->item($goal,new GoalTransformer());
    }

    public function store(GoalRequest $request,Goal $goal){
        $goal->fill($request->all());
        $goal->user()->associate($this->user);
        $goal->save();
        return response(null,201);
    }

    public function update(GoalRequest $request,Goal $goal){
        $data = $request->all();
        if($amount=$request->amount){
            $currentAmount = $goal->mission_accomplish_amount+$amount;
            $missionAccomplishAmount = $currentAmount>=0?$currentAmount:0;
            $data['mission_accomplish_amount'] = $missionAccomplishAmount;

            if(is_null($goal->done_at)&&$missionAccomplishAmount>=$goal->mission_amount){
                $data['done_at'] = now()->toDateString();
            }
        }
        if($request->get_awards&&$goal->can_get_the_awards){
            $data['gain_at'] = now()->toDateTimeString();
            $user = $goal->user;
            $user->update(['bonus'=>($user->bonus+$goal->bonus)]);
        }

        $goal->update($data);

        return $this->response->item($goal,new GoalTransformer());
    }

    public function destroy(Request $request,Goal $goal){
        $goal->delete();
        return $this->response->noContent();
    }



}
