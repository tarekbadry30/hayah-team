<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileSlider extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts = [
        'created_at'  => 'datetime:Y-m-d h:i:s a',
    ];
    protected $appends=['image'];
    public function getImageAttribute(){
        if(isset($this->img))
            return $this->img;
        return 'no_img.png';
    }
    public function uploadParams(){
        return [
            'msg'=>__('frontend.uploadImageOf').__('frontend.MobileSlider'),
            'input'=>[
                'name'=>'slider_id',
                'value'=>0
            ],
            'files'=>['max'=>1,'mimes'=>".jpeg,.jpg,.png"],
            'uploadRoute'=>route('mobile-sliders.uploadImg'),
            'backRoute'=>url()->previous(),
        ];
    }
}
