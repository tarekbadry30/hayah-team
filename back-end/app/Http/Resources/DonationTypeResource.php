<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonationTypeResource extends JsonResource
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
        return [
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
            //'categories'=>  $this->categories,
            //'categories'=>  CategoryResouce::collection($this->categories),
        ];


    }
}
