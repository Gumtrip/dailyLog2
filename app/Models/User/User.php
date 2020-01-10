<?php

namespace App\Models\User;

use App\Models\Bonus\BonusLog;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','mobile','bonus'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** //返回了 User 的 id
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /** //我们需要额外再 JWT 载荷中增加的自定义内容
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function bonusLogs(){
        return $this->hasMany(BonusLog::class);
    }
}
