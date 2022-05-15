<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'img'   =>  asset($this->food->img),

            'name'      =>  [
                'ar'=>$this->food->translate('ar')->name,
                'en'=>$this->food->translate('en')->name,
            ],
            'desc'      =>  [
                'ar'=>$this->food->translate('ar')->desc,
                'en'=>$this->food->translate('en')->desc,
            ],
            'type'              =>  $this->food->type,
            'amount'            =>  $this->amount,
            'price'             =>  $this->food->price,
            'total'             =>  $this->food->price*$this->amount,
        ];
    }
}
