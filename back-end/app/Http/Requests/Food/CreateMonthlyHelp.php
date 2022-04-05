<?php

namespace App\Http\Requests\Food;

use Illuminate\Foundation\Http\FormRequest;

class CreateMonthlyHelp extends FormRequest
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
                'user_id'  => 'required',
                'month'    => 'required',
                'help_value'=> 'required|numeric|min:0.1',
            ];

        }
        else {
            $rules = [
                'user_id'  => 'required',
                'month'    => 'required',
                'help_value'=> 'required|numeric|min:0.1',
            ];
        }
        return $rules;
    }
}
