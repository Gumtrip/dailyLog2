<?php

namespace App\Http\Requests\Admin\Product;

use App\Http\Requests\Admin\BackendRequest as FormRequest;
use App\Models\Product\ProductCategory;
use Request;
use Illuminate\Validation\Rule;
class ProductCategoryRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $data = [
            'title' => 'required'
        ];
        switch ($this->method()){
            case 'POST':$data = array_merge($data,[
                'parent_id'=>[function($attribute, $value, $fail){
                    if(!is_null($value)&&$value){
                        $parentCategory = ProductCategory::withDepth()->findOrFail ($value);
                        if($parentCategory->depth > 1)return $fail('最多支持3级分类');
                    }
                }]
            ]);break;
            case 'PATCH':$data = array_merge($data,[
                'parent_id'=>[function($attribute, $value, $fail){
                    if(!is_null($value)&&$value){
                        $parentCategory = ProductCategory::withDepth()->findOrFail ($value);
                        //这里需要保证父级dept=0,自身允许有一级子节点
                        if($parentCategory->depth > 1)return $fail('最多支持3级分类');
                        //这里需要保证父级dept=1,自身没有任何子节点
                        $productCategory = request('product_category');
                        if($parentCategory->depth == 1&&$productCategory->descendants->count()>0)return $fail('最多支持3级分类');
                    }
                }]
            ]);break;
        }
        return $data;
    }
}
