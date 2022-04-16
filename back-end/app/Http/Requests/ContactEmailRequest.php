<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactEmailRequest extends FormRequest
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
        $new = (request()->has('id') && intval(request()->id) > 0);
        if (!$new) {
            $rules = [
                'ar.name' => 'required|string|unique:contact_email_translations,name',
                'en.name' => 'required|string|unique:contact_email_translations,name',
                'email' => 'required|email',
            ];

        } else {
            $rules = [
                'ar.name' => 'required|string|unique:contact_email_translations,name,' . request()->id . ',contact_email_id',
                'en.name' => 'required|string|unique:contact_email_translations,name,' . request()->id . ',contact_email_id',
                'email' => 'required|email',
            ];
        }
        return $rules;
    }
}
