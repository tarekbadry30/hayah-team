<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationTypeRequest extends FormRequest
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
                'ar.name'   => 'required|string|unique:donation_type_translations,name',
                'en.name'   => 'required|string|unique:donation_type_translations,name',
                'status'    => 'required',
            ];

        }
        else {
            $rules = [
                'ar.name'   => 'required|string|unique:donation_type_translations,name,'. request()->id.',donation_type_id',
                'en.name'   => 'required|string|unique:donation_type_translations,name,'. request()->id.',donation_type_id',
                'status'    => 'required',
            ];
        }
        return $rules;
    }
}
