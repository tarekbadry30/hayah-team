<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NestedDonationTypes extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'        =>  $this->id,
            'name'      =>  $this->translate(LaravelLocalization::getCurrentLocale())->name,
            'desc'      =>  $this->translate(LaravelLocalization::getCurrentLocale())->desc,
            //'categories'=>  $this->categories,
            'categories'=>  NestedCategory::collection($this->categories),
        ];
    }
}
