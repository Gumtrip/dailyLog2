<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-15
 * Time: 12:00
 */

namespace App\Traits;


Trait SMSVerify
{
    /**
     * @param $verificationKey
     * @param $verificationCode
     * @return bool
     * @throws \Exception
     */
    function verifySMSCode($verificationKey, $verificationCode):bool
    {
        $verifyData = cache($verificationKey);
        if (!$verifyData) {
            //验证码已失效
            return false;
        }
        if (!hash_equals($verifyData['code'], $verificationCode)) {
            // 返回401 验证码错误
            return false;
        }
        return true;
    }
}