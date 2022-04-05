<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMonthHelp extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $casts = [
        'created_at'    => 'datetime:Y-m-d h:i:s a',
        'month'         => 'datetime:Y-m',
    ];
    public function scopeCustomFilter($query,$filters){
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
            $query->whereBetween('month', $dates);
        }
        if(isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
        return $query;
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
