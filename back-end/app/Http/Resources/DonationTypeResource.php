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
            'name'      =>  $this->translate($locale)->name,
            'desc'      =>  $this->translate($locale)->desc,
            //'categories'=>  $this->categories,
            'categories'=>  CategoryResouce::collection($this->categories),
        ];
    }
}
