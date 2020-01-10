<?php

namespace App\Http\Requests\Api\Frontend\Auth;

use App\Http\Requests\Frontend\FormRequest;

class LoginViaCodeRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'verificationKey' => 'required',
            'verificationCode' => 'required',
            'mobile' => [
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/',
                'required',
            ],
        ];
    }
    public function attributes(){
        return [
            'verificationCode'=>'验证码'
        ];
    }}
