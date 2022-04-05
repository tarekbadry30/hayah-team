<?php

namespace App\Http\Requests\Food;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateFoodRequest extends FormRequest
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
        $new=(request()->has('id')&&intval(request()->id)>0);
        if(!$new) {
            $rules = [
                'ar.name'  => 'required|string|unique:food_translations,name',
                'en.name'  => 'required|string|unique:food_translations,name',
                //'ar.desc'  => 'required|string',
                //'en.desc'  => 'required|string',
                'type'     => 'required',
                'price'    => 'required|numeric|min:0.1',
            ];

        }
        else {
            $rules = [
                'ar.name'  => 'required|string|unique:food_translations,name,'. request()->id.',food_id',
                'en.name'  => 'required|string|unique:food_translations,name,'. request()->id.',food_id',
                //'ar.desc'  => 'required|string',
                //'en.desc'  => 'required|string',
               // 'status'   => 'required',
                'type'     => 'required',
                'price'    => 'required|numeric|min:0.1',
            ];
        }
        return $rules;
    }
}
