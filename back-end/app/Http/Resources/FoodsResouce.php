<?php

namespace App\Http\Resources;

use App\Models\UserMonthFood;
use App\Models\UserMonthHelp;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodsResouce extends JsonResource
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
            'id'    =>  $this->id,
            'name'  =>  [
                'ar'=>$this->translate('ar')->name,
                'en'=>$this->translate('en')->name,
            ],
            'desc'  =>  [
                'ar'=>$this->translate('ar')->desc,
                'en'=>$this->translate('en')->desc,
            ],
            'price' =>  $this->price,
            'img'   =>  asset($this->img),
            //'translations' =>  $this->translations,
        ];
    }
    public function with($request)
    {
        $month=UserMonthHelp::where([
            ['month',Carbon::now()->format('Y-m').'-01 00:00:00'],
            ['user_id',auth('auth:sanctum')->id()]
        ])->first();
        return [
        'current_help_month' =>$month
        ];
    }
}
