<?php

namespace App\Observers\Goal;

use App\Models\Goal\Goal;
use App\Models\Goal\GoalLog;
use App\Services\LogService;
use App\Models\Bonus\BonusLog;
use DB;
class GoalObserver
{
    protected $keyCn=[
        'mission_accomplish_amount'=>'完成任务数量',
        'remark'=>'备注',
        'done_at'=>'完成时间',
        'gain_at'=>'领取奖品时间',
        'cancel_at'=>'取消时间',
        'fail_at'=>'失败时间',
    ];



    /**
     * Handle the goal "created" event.
     *
     * @param  Goal  $goal
     * @return void
     */
    public function created(Goal $goal)
    {
        $logService = app(LogService::class);
        $properties = $logService->handleCreateAttributes($goal);
        $description='【新建】';
        $goalLog = new GoalLog([
            'properties'=>$properties,
            'description'=>$description,
        ]);
        $goalLog->goal()->associate($goal);
        $goalLog->save();
    }



    /**
     * Handle the goal "updated" event.
     *
     * @param  Goal  $goal
     * @return void
     */
    public function updated(Goal $goal)
    {
//目标修改日志
        $logService = app(LogService::class);
        $properties = $logService->updateProperties($goal->only($goal->getFillable()),$goal->getOriginal());
        $description = $logService->generateDescription($properties,$this->keyCn);
        $goalLog = new GoalLog([
            'properties'=>$properties,
            'description'=>$description,
        ]);
        $goalLog->goal()->associate($goal);
        $goalLog->save();
    }

    /**
     * Handle the goal "deleted" event.
     *
     * @param  Goal  $goal
     * @return void
     */
    public function deleted(Goal $goal)
    {
        //
    }

    /**
     * Handle the goal "restored" event.
     *
     * @param  Goal  $goal
     * @return void
     */
    public function restored(Goal $goal)
    {
        //
    }

    /**
     * Handle the goal "force deleted" event.
     *
     * @param  Goal  $goal
     * @return void
     */
    public function forceDeleted(Goal $goal)
    {
        //
    }
}
