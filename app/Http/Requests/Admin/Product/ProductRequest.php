<?php

namespace App\Http\Requests\Admin\Product;

use App\Http\Requests\Admin\BackendRequest as FormRequest;
class ProductRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = [
            'title' => 'required',
            'category_id' => 'required',
            'images' => 'required|array',
        ];
        return $data;
    }
}
