<?php

namespace App\Http\Requests\Admin\Auth;

use App\Http\Requests\Admin\BackendRequest as FormRequest;

class LoginRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile'=>'required',
            'password'=>'required',
        ];
    }
}
