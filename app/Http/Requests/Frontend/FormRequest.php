<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        return auth()->checkout();
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

}
