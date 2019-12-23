<?php

namespace App\Http\Requests\Admin\Image;

use App\Http\Requests\Admin\BackendRequest as FormRequest;

class ImageRequest extends FormRequest
{


    public function rules()
    {
        return [
            'image' => 'required|mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200'
        ];
    }

    public function attributes(){
        return [
            'image' => '图片'
        ];
    }

    public function messages()
    {
        return [
            'image.dimensions' => '图片的清晰度不够，宽和高需要 200px 以上',
        ];
    }
}
