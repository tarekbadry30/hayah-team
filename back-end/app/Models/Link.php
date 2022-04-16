<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    use Translatable;
    protected $guarded=[];
    public $translatedAttributes = ['name'];
    protected $casts = [
        'created_at'  => 'datetime:Y-m-d h:i:s a',
    ];
}
