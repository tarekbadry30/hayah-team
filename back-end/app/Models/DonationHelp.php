<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationHelp extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    protected $guarded=[];
    public $translatedAttributes = ['name', 'desc'];
    protected $casts = [
        'created_at'  => 'datetime:Y-m-d h:i:s a',
    ];
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function donationType(){
        return $this->belongsTo(DonationType::class,'type_id');
    }
    public function scopeCustomFilter($query,$filters){
        if(isset($filters['type_id']))
            $query->where('type_id',$filters['type_id']);
        if(isset($filters['category_id']))
            $query->where('category_id',$filters['category_id']);
        /*if(isset($filters['status']))
            $query->where('status',$filters['status']);*/
        if(isset($filters['date'])) {
            if(str_contains($filters['date'],' to ')){
                $dates = explode(" to ", $filters['date']);
                $dates[0]=$dates[0].' 00:00:00';
                $dates[1]=$dates[1].' 23:59:59';
            }
            else{
                $dates =[];
                $dates[0]=$filters['date'].' 00:00:00';
                $dates[1]=$filters['date'].' 23:59:59';
            }
            $query->whereBetween('created_at', $dates);
        }
        return $query;
    }

    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id');
    }
    public function uploadParams(){
        return [
            'msg'=>__('frontend.uploadImageOf').$this->name,
            'input'=>[
                'name'=>'donation_help_id',
                'value'=>$this->id
            ],
            'files'=>['max'=>1,'mimes'=>".jpeg,.jpg,.png"],
            'uploadRoute'=>route('donations-help.uploadImg'),
            'backRoute'=>url()->previous(),
        ];
    }
}
