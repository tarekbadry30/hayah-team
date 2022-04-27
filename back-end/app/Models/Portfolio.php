<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;
    use Translatable;
    protected $guarded=[];
    protected $translatedAttributes=['name','desc'];
    protected $casts = [
        'created_at'  => 'datetime:Y-m-d h:i:s a',
    ];
    protected $appends=['image'];
    public function getImageAttribute(){
        if(isset($this->img))
            return $this->img;
        return 'no_img.png';
    }
}
