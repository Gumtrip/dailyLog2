<?php

namespace App\Models\Goal;

use Illuminate\Database\Eloquent\Model;
class GoalLog extends Model
{
    protected $fillable=['description','properties'];
    protected $casts=[
        'properties'=>'array'
    ];


    public function goal(){
        return $this->belongsTo(Goal::class);
    }



}
