<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Http\Traits\ModelTranslates;

class CategoryOption extends Model implements TranslatableContract
{
    use ModelTranslates;
    use HasFactory;
    use Translatable;
    public $translatedAttributes = ['name'];
    protected $guarded =[];
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
