<?php

namespace App\Http\Requests\Frontend\Goal;

use App\Http\Requests\Frontend\FormRequest;


class GoalRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()){
            case 'POST':
                return [
                    'title' => 'required|string',
                    'mission_amount' => 'required|numeric|gt:0',
                    'start_at' => 'required|date',
                    'end_at' => 'required|date',
                    'done_at' => 'date',
                    'cancel_at' => 'date',
                ];
                break;
            case 'PATCH':
                return [
                    'title' => 'string',
                    'accomplish_amount' => 'numeric',
                    'start_at' => 'date',
                    'end_at' => 'date',
                    'cancel_at' => 'date',
                ];
                break;
        }
    }
    public function attributes()
    {
        return [
            'title' => '标题',
            'start_at' => '开始时间',
            'end_at' => '结束时间',
            'done_at' => '完成时间',
            'cancel_at' => '取消时间',
        ];
    }
}
