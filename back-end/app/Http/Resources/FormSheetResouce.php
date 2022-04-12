<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormSheetResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //$this->inputs->earch->setTranslated('')
        return [
            'id'    =>  $this->id,
            'name'  =>  [
                'ar'=>$this->translate('ar')->name,
                'en'=>$this->translate('en')->name,
            ],
            'inputs'=>FormSheetInputResouce::collection($this->inputs),
        ];
    }
}
