<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinksRequest extends FormRequest
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
                'ar.name'  => 'required|string|unique:link_translations,name',
                'en.name'  => 'required|string|unique:link_translations,name',
                'type'     => 'required',
                'link'     => 'required|url',
            ];

        }
        else {
            $rules = [
                'ar.name'  => 'required|string|unique:link_translations,name,'. request()->id.',link_id',
                'en.name'  => 'required|string|unique:link_translations,name,'. request()->id.',link_id',
                'type'     => 'required',
                'link'     => 'required|url',
            ];
        }
        return $rules;
    }
}
