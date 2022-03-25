<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model  implements TranslatableContract
{
    use Translatable;
    use HasFactory;
    protected $guarded=[];
    public $translatedAttributes = ['name', 'desc'];

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }
    public function childes()
    {
        return $this->hasMany(Category::class,'parent_id');
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
