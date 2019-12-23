<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements JWTSubject
{
    protected $fillable=['name','mobile','password'];



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
}
