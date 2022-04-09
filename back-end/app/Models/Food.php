<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Http\Traits\ModelTranslates;

class Food extends Model implements TranslatableContract
{
    use ModelTranslates;
    use HasFactory;
    use Translatable;
    public $translatedAttributes = ['name', 'desc'];
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
            'msg'=>__('frontend.uploadImageOf').$this->name,
            'input'=>[
                'name'=>'food_id',
                'value'=>$this->id
            ],
            'files'=>['max'=>1,'mimes'=>".jpeg,.jpg,.png"],
            'uploadRoute'=>route('foods.uploadImg'),
            'backRoute'=>url()->previous(),
        ];
    }
    public static function filters(){
        return [
            [
                "label"     =>  "name",
                "operators" =>  [
                    "="=>"".__('frontend.equal'),
                ]
            ],
            [
                "label"     =>  "name",
                "operators" =>  [
                    "="=>"".__('frontend.equal'),
                ]
            ]
        ];
    }

    public function scopeCustomFilter($query,$filters){
        if(isset($filters['type']))
            $query->where('type',$filters['type']);
        if(isset($filters['status']))
            $query->where('status',$filters['status']);
        if(isset($filters['min_price']))
            $query->where('price','>=',$filters['min_price']);
        if(isset($filters['max_price']))
            $query->where('price','<=',$filters['max_price']);
        if(isset($filters['date'])) {
            if(str_contains($filters['date'],' to ')){
                $dates = explode(" to ", $filters['date']);
                $dates[0]=$dates[0].' 00:00:00';
                $dates[1]=$dates[1].' 23:59:59';
            }else{
                $dates =[];
                $dates[0]=$filters['date'].' 00:00:00';
                $dates[1]=$filters['date'].' 23:59:59';
            }
            $query->whereBetween('created_at', $dates);
        }
        return $query;
    }

}
