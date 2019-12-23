<?php

namespace App\Http\Requests\Admin\Article;

use App\Http\Requests\Admin\BackendRequest as FormRequest;

class ArticleRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>'required',
            'intro'=>'required',
            'desc'=>'required',
            'image'=>'required',
        ];
    }
}
