<?php

namespace App\Models\Goal;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use App\Models\User\User;
class GoalCategory extends Model
{
    use NodeTrait;

    protected $fillable=['title'];

    public function goals(){
        return $this->hasMany(Goal::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
