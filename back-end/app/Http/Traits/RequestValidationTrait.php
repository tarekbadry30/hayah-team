<?php


namespace App\Http\Traits;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

trait RequestValidationTrait
{
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $errors = (new ValidationException($validator))->errors();
            $errorsIndexedArray=[];
            $errorsArray=[];
            foreach ($errors as $key=>$error){
                $errorsArray[$key]=implode(' , ',array_values($error));
                $errorsIndexedArray[]=implode(' , ',array_values($error));
            }
            $errorsIndexedArray=implode(' \n ',$errorsIndexedArray);
            throw new HttpResponseException(
                response()->json(['message'=>'Validation Error','errors'=>$errorsIndexedArray],422)
            );
        }

        parent::failedValidation($validator);
    }

}

