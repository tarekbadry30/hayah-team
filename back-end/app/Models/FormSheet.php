<?php

namespace App\Models;

use App\Http\Traits\ModelTranslates;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSheet extends Model
{
    use HasFactory;
    use ModelTranslates;
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['name'];

    protected $guarded=[];

    protected $casts = [
        'created_at'  => 'datetime:Y-m-d h:i:s a',
    ];
    public function getVisibleRangeAttribute(){
        $visibleRange='';
        if(isset($this->from)&&isset($this->to)){
            return $this->from.' to '.$this->to;
        }
        return $visibleRange;
    }
    public function inputs(){
        return $this->hasMany(FormSheetInput::class,'form_sheet_id');
    }
    public function answers(){
        return $this->hasMany(FormSheetUserAnswer::class,'form_sheet_id');
    }
    public function scopeCustomFilter($query,$filters){
        if(isset($filters['user_type']))
            $query->where('user_type',$filters['user_type']);
        if(isset($filters['visible']))
            $query->where('visible',$filters['visible']);

        if(isset($filters['date'])) {
            if(str_contains($filters['date'],' to ')){
                $dates = explode(" to ", $filters['date']);
                $dates[0]=$dates[0];//.' 00:00:00';
                $dates[1]=$dates[1];//.' 23:59:59';
            }else{
                $dates =[];
                $dates[0]=$filters['date'];//.' 00:00:00';
                $dates[1]=$filters['date'];//.' 23:59:59';
            }
            $query->where([
                ['from',$dates[0]],
                ['to',$dates[1]],
            ]);
        }
        return $query;
    }
}
