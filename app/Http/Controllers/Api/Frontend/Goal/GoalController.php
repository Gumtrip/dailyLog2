<?php

namespace App\Http\Controllers\Api\Frontend\Goal;

use App\Http\Resources\Goal\GoalResource;
use App\Models\Bonus\BonusLog;
use App\Services\LogService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Goal\Goal;
use App\Http\Requests\Frontend\Goal\GoalRequest;
use DB;

class GoalController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function index(Request $request, Goal $goal)
    {
        $query = $goal->query();
        if ($this->user) {
            $query->where('user_id', $this->user->id);
        } else {
            $query->whereNull('user_id');
        }
        $goals = $query->orderBy('id', 'desc')->paginate(config('app.page_size'));
        return GoalResource::collection($goals);
    }

    public function show(Request $request, Goal $goal)
    {
        return new GoalResource($goal);
    }

    public function store(GoalRequest $request, Goal $goal)
    {
        $goal->fill($request->all());
        $goal->user()->associate($this->user->id);
        $goal->save();
        return response(null, 201);
    }

    public function update(GoalRequest $request, Goal $goal)
    {
        $data = $request->all();
        if ($accomplish_amount = $request->accomplish_amount) {
            $currentAmount = $goal->mission_accomplish_amount + $accomplish_amount;
            $missionAccomplishAmount = $currentAmount >= 0 ? $currentAmount : 0;
            $data['mission_accomplish_amount'] = $missionAccomplishAmount;
            if (is_null($goal->done_at) && $missionAccomplishAmount >= $goal->mission_amount) {
                $data['done_at'] = now()->toDateTimeString();
            }
        }

        //获取奖品
        if ($request->get_awards && $goal->can_get_the_awards) {
            $data['gain_at'] = now()->toDateTimeString();
            $user = $this->user;

            $TotalBonus = ($this->user->bonus) + ($goal->bonus);

            //插入日志
            $logService = app(LogService::class);
            $properties = $logService->updateProperties( ['bonus' => $TotalBonus],$user->only(['bonus']));
            $description = $logService->generateDescription($properties, $keyCn = ['bonus' => '奖金']);
            $bonusLog = new BonusLog([
                'properties' => $properties,
                'description' => $description,
            ]);
            $bonusLog->goal()->associate($goal);
            $bonusLog->user()->associate($user);
            $bonusLog->save();


            $user->increment('bonus' , $goal->bonus);

        }

        $goal->update($data);


        return new GoalResource($goal);
    }

    public function destroy(Request $request, Goal $goal)
    {
        $goal->delete();
        return response(null, 204);
    }


}
