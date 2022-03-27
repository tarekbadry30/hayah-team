<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class DonationType extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;
    protected $guarded=[];
    public $translatedAttributes = ['name', 'desc'];
    public function categories(){
        return $this->hasMany(Category::class,'type_id');
    }
}
