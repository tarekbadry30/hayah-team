<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonationHelpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $donationType=$this->type_id?[
            'id'=>$this->donationType->id,
            'name'  =>  [
                'ar'=>$this->donationType->translate('ar')->name,
                'en'=>$this->donationType->translate('en')->name,
            ],
            'desc'  =>  [
                'ar'=>$this->donationType->translate('ar')->desc,
                'en'=>$this->donationType->translate('en')->desc,
            ],
        ]:[];
        $category=$this->category_id?[
            'id'=>$this->category->id,
            'name'  =>  [
                'ar'=>$this->category->translate('ar')->name,
                'en'=>$this->category->translate('en')->name,
            ],
            'desc'  =>  [
                'ar'=>$this->category->translate('ar')->desc,
                'en'=>$this->category->translate('en')->desc,
            ],
        ]:[];
        return [
            'id'            =>   $this->id,
            'donation_type' =>$donationType,
            'category'      =>$category,
            'name'  =>  [
                'ar'=>$this->translate('ar')->name,
                'en'=>$this->translate('en')->name,
            ],
            'desc'  =>  [
                'ar'=>$this->translate('ar')->desc,
                'en'=>$this->translate('en')->desc,
            ],
            'img'   =>  asset($this->img),
        ];
    }
}
