<?php

namespace App\Models\Goal;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reward\Reward;
use App\Models\User\User;
use Carbon\Carbon;
class Goal extends Model
{
    protected $fillable=['title','remark','mission_amount','mission_accomplish_amount','start_at','gain_at','end_at','done_at','cancel_at','fail_at','bonus'];
    protected $casts=[

    ];

    public function rewards(){
        return $this->hasMany(Reward::class);
    }
    public function goalLogs(){
        return $this->hasMany(GoalLog::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    /** 是否达成目标
     * @return bool
     */
    public function getIsReachTheGoalAttribute(){
        return $this->mission_accomplish_amount>=$this->mission_amount;
    }


    public function getCanGetTheAwardsAttribute(){
        return $this->done_at&&$this->is_ahead_end_time&&is_null($this->gain_at);
    }




    /** 是否已经超过时间了
     * @return bool
     */

    public function getIsOverEndTimeAttribute(){
        return now()->gt(Carbon::parse($this->end_at));
    }

    /**
     * 是否还没开始
     */

    public function getIsAheadStartTimeAttribute(){
        return now()->lt(Carbon::parse($this->start_at));

    }

    /**
     * 在结束之前
     */

    public function getIsAheadEndTimeAttribute(){
        return now()->lt(Carbon::parse($this->end_at));

    }

    /** 是否在开始和结束时间之内
     * @return bool
     */

    public function getIsBetweenStartTimeAndEndTimeAttribute(){
        return now()->between(Carbon::parse($this->start_at),Carbon::parse($this->end_at));
    }
}
