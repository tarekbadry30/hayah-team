<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'about'  =>  [
                'ar'=>$this->translate('ar')->about,
                'en'=>$this->translate('en')->about,
            ],
            'goals'  =>  [
                'ar'=>$this->translate('ar')->goals,
                'en'=>$this->translate('en')->goals,
            ],
            'vision'  =>  [
                'ar'=>$this->translate('ar')->vision,
                'en'=>$this->translate('en')->vision,
            ]
        ];
    }
}
