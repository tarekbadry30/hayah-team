<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryOptionResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $locale= $request->header('locale')? $request->header('locale') : app()->getLocale();
        return[
            'id'                =>  $this->id,
            'name'              =>  $this->translate($locale)->name,
            'type'              =>  $this->type,
            'default_value'     =>  $this->default_value,
            'accept_any_value'  =>  $this->accept_any_value?true:false,
        ];
    }
}
