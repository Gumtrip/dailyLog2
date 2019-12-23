<?php
return [
    /*
     * 接口频率限制
     */
    'rate_limits' => [
        // 访问频率限制，次数/分钟
        'access' =>  env('RATE_LIMITS', '60,1'),
        // 登录相关，次数/分钟
        'sign' =>  env('SIGN_RATE_LIMITS', '10,1'),
    ],
    'jwt'=>[
        'ttl'=>env('JWT_TTL',60),
//        'refresh_ttl'=>env('JWT_REFRESH_TTL ',60)
    ],

];
