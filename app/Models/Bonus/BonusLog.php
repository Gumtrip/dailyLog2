<?php

namespace App\Models\Bonus;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;
use App\Models\Goal\Goal;
class BonusLog extends Model
{
    protected $fillable=['description','properties'];

    protected $casts=[
        'properties'=>'array'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function goal(){
        return $this->belongsTo(Goal::class);
    }
}
