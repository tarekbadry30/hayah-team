<?php

namespace App\Models;

use App\Http\Traits\ModelTranslates;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSheetInput extends Model
{
    use HasFactory;
    use ModelTranslates;
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded=[];

}
