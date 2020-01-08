<?php

namespace App\Models\Goal;

use Illuminate\Database\Eloquent\Model;

class GoalCategory extends Model
{
    protected $fillable=['title'];

    public function goals(){
        return $this->hasMany(Goal::class);
    }
}
