<?php

namespace App\Http\Resources\API;

use App\Http\Resources\CategoryOptionResouce;
use App\Http\Resources\CategoryResouce;
use App\Http\Resources\DonationTypeResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryOrder extends JsonResource
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
            'type'              =>  $this->donation->type,
            'value'             =>  $this->donation->value,
            'map_location'      =>  $this->map_location,
            'notes'             =>  $this->notes,
            'status'            =>  $this->status,
            'donation_type'     =>  $this->donation->donationType->translate($locale)->name,
            'category'          =>  $this->donation->category->translate($locale)->name,
            'option'            =>  $this->donation->option->translate($locale)->name,
            'user'              =>  $this->donation->user,
            'order_date'        =>  Carbon::parse($this->created_at)->format('Y-m-d h:i:s a'),
            'donation_date'     =>  Carbon::parse($this->donation->created_at)->format('Y-m-d h:i:s a'),
        ];
    }
}
