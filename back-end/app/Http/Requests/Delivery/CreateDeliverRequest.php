<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class CreateDeliverRequest extends FormRequest
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
                'name'  => 'required|string',
                'phone' => 'required|string|unique:deliveries',
                'status'    =>'required',
                'password' => 'required|string|min:6',
            ];
            if(request()->national_number)
                $rules['national_number']= 'required|string|unique:deliveries';
        }
        else {
            $rules = [
                'name'      => 'required|string',
                'phone'     => 'required|string|unique:deliveries,phone,' . request()->id,
                'type'      =>'required',
                'status'    =>'required',
                //'national_number'=>'required|string|unique:deliveries,national_number,'.request()->id,
            ];
            if(request()->password)
                $rules['password']= 'required|string|min:6';
        }
        return $rules;
    }
}
