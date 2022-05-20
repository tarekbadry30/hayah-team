<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryHelpAskResource extends JsonResource
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
            'type'              =>  new DonationTypeResource($this->donationType),
            'category'          =>  new CategoryResouce($this->category),
            'donationHelp'      =>  new DonationHelpResource($this->donationHelp),
            'user'              =>  $this->user,
            'order_date'        =>  Carbon::parse($this->created_at)->format('Y-m-d h:i:s a'),
        ];
    }
}
