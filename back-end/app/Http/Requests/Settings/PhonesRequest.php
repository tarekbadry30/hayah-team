<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class PhonesRequest extends FormRequest
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
                'ar.*'      => 'required',
                'en.*'      => 'required',
                'phone'     => 'required|string|unique:contact_phones',
            ];

        }
        else {
            $rules = [
                'ar.*'      => 'required',
                'en.*'      => 'required',
                'phone'     => 'required|string|unique:contact_phones,phone,'. request()->id,
            ];
        }
        return $rules;
    }
}
