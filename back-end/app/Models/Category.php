<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Http\Traits\ModelTranslates;
class Category extends Model  implements TranslatableContract
{
    use ModelTranslates;
    use Translatable;
    use HasFactory;
    protected $guarded=[];
    public $translatedAttributes = ['name', 'desc'];
    protected $appends=['image'];
    public function scopeCustomFilter($query,$filters){
        if(isset($filters['type_id']))
            $query->where('type_id',$filters['type_id']);
        if(isset($filters['urgent']))
            $query->where('urgent',$filters['urgent']);
        if(isset($filters['status']))
            $query->where('status',$filters['status']);
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
            /*echo json_encode($dates);
            die();*/
            $query->whereBetween('created_at', $dates);
        }
        return $query;
    }

    public function getImageAttribute(){
        if(isset($this->img))
            return $this->img;
        return 'no_img.png';
    }
    public function type()
    {
        return $this->belongsTo(DonationType::class,'type_id');
    }

    public function options()
    {
        return $this->hasMany(CategoryOption::class,'category_id');
    }
    public function uploadParams(){
        return [
            'msg'=>__('frontend.uploadImageOf').$this->name,
            'input'=>[
                'name'=>'category_id',
                'value'=>$this->id
            ],
            'files'=>['max'=>1,'mimes'=>".jpeg,.jpg,.png"],
            'uploadRoute'=>route('categories.uploadImg'),
            'backRoute'=>url()->previous(),
        ];
    }
}
