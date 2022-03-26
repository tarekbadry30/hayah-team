<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResouce extends JsonResource
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
            'id'        =>  $this->id,
            'img'       =>  asset($this->img),
            'name'      =>  $this->translate($locale)->name,
            'desc'      =>  $this->translate($locale)->desc,
            'sub_categories'=>  CategoryResouce::collection($this->childes),
            'options'   =>  CategoryOptionResouce::collection($this->options),
        ];
    }
}
