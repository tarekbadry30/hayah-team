<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SharedIdeaRequest extends FormRequest
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
            'idea'                  =>'required',
            'target_group'          =>'required',
            'execution_mechanism'   =>'required',
            'name'                  =>'required',
            'phone'                 =>'required',
            'money'                 =>'required',
            'timing'                =>'required',
        ];
    }
}
