<?php

namespace App\Http\Requests\Donation;

use App\Http\Traits\RequestValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class CreateDonationRequest extends FormRequest
{
    use RequestValidationTrait;

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
            'option_id'     =>'required',
            'desc'          =>'required',
        ];
    }
}
