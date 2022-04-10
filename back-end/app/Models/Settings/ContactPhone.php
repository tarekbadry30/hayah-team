<?php

namespace App\Models\Settings;

use App\Http\Traits\ModelTranslates;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPhone extends Model
{
    use HasFactory;
    use ModelTranslates;
    use Translatable;
    protected $guarded=[];
    public $translatedAttributes = ['name'];
}
