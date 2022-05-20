<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryFoodResource extends JsonResource
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
            'id'                =>  $this->id,
            'lat'               =>  $this->lat,
            'long'              =>  $this->long,
            'notes'             =>  $this->notes,
            'status'            =>  $this->status,
            'address'           =>  $this->address,
            'user'              =>  $this->user,
            'foods'             =>   FoodsResouce::collection($this->items),
            'order_date'        =>  Carbon::parse($this->created_at)->format('Y-m-d h:i:s a'),
        ];
    }
}
