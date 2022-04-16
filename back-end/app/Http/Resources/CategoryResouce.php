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
        //$locale= $request->header('locale')? $request->header('locale') : app()->getLocale();
        return[
            'id'        =>  $this->id,
            'img'       =>  asset($this->image),
            'name'      =>  [
                'ar'=>$this->translate('ar')->name,
                'en'=>$this->translate('en')->name,
            ],
            'desc'      =>  [
                'ar'=>$this->translate('ar')->desc,
                'en'=>$this->translate('en')->desc,
            ],
            'urgent'            =>  $this->urgent?true:false,
            'collected_value'   =>  $this->collected_value,
            'needed_value'      =>  $this->needed_value,
            'options'           =>  CategoryOptionResouce::collection($this->options),
        ];
    }
}
