<?php

namespace App\Http\Requests\Frontend\Seckill;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Seckill\SeckillProduct;
use Illuminate\Auth\AuthenticationException;
class SeckillPlaceOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'seckillProductId'=>['required',function($attribute, $value, $fail){

            //在redis 中读取库存
                $stock = cache('seckillProduct-'.$value);

                if(is_null($stock))return $fail('商品不存在');

                if($stock<1)return $fail('该商品已售完');
                //在redis 中读取库存

                //延迟身份校验
//                if(!$user = auth('api')->check()){
//                    throw new AuthenticationException('请先登录');
//                }

                //将下了单的用户写入reids 当中，防止同一用户下了多个抢购订单！

                //产品信息也可以写入redis 当中，减少mysql 的查询
                //也可以不写入redis，因为大部分用户已经 在库存那里被拒绝了，而且通过id查询一条记录，消耗的资源非常小！
                $seckillProduct = SeckillProduct::find($value);
                if ($seckillProduct->is_before_start_date) {
                    return $fail('秒杀尚未开始');
                }
                if ($seckillProduct->is_after_end_date) {
                    return $fail('秒杀已经结束');
                }
                if ($seckillProduct->stock < 1) {
                    return $fail('该商品已售完');
                }
            }]
        ];
    }
}
