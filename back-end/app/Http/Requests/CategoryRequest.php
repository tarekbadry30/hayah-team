<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                'ar.*'  => 'required',
                'en.*'  => 'required',
                'ar.name'  => 'required|string|unique:category_translations,name',
                'en.name'  => 'required|string|unique:category_translations,name',
                'ar.desc'  => 'required|string',
                'en.desc'  => 'required|string',
                'status'=> 'required',
                //'status'    =>'required',
                //'img'   => 'required',
            ];

        }
        else {
            $rules = [
                'ar.*'  => 'required',
                'en.*'  => 'required',
                'ar.name'  => 'required|string|unique:category_translations,name,'. request()->id.',category_id',
                'en.name'  => 'required|string|unique:category_translations,name,'. request()->id.',category_id',
                'ar.desc'  => 'required|string',
                'en.desc'  => 'required|string',
                'status'=> 'required',
            ];
        }
        return $rules;
    }
}
