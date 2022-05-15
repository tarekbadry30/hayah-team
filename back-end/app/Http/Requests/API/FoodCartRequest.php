<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class FoodCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('sanctum')->user()->type=='needy';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'food_id'   =>'required',
            'amount'    =>'required|int|min:1',
        ];
    }
}
