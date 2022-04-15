<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NestedCategoryOption extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'                =>  $this->id,
            'name'              =>  $this->translate(LaravelLocalization::getCurrentLocale())->name,
            'type'              =>  $this->type,
            'default_value'     =>  $this->default_value,
            'accept_any_value'  =>  $this->accept_any_value?true:false,
        ];
    }
}
