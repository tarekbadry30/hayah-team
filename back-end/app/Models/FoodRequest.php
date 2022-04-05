<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\Translation\t;

class FoodRequest extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts = [
        'created_at'  => 'datetime:Y-m-d h:i:s a',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function delivery(){
        return $this->belongsTo(Delivery::class,'delivery_id');
    }
    public function month(){
        return $this->belongsTo(UserMonthHelp::class,'month_id');
    }
    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id');
    }
    public function monthFood(){
        return $this->hasMany(UserMonthFood::class,'request_id');
    }
    public function items(){
        return $this->belongsToMany(Food::class,'user_month_food','request_id','food_id');
    }

    public function scopeCustomFilter($query,$filters){
        if(isset($filters['user_id']))
            $query->where('user_id',$filters['user_id']);
        if(isset($filters['month'])) {
            $month=Carbon::parse('01-'.$filters['month'])->format('Y-m-d H:i:s');
            $ids=UserMonthHelp::where('month',$month)->pluck('id');
            $query->whereIn('month_id', $ids);
        }
        if(isset($filters['status']))
            $query->where('status',$filters['status']);
        if(isset($filters['delivery_id']))
            $query->where('delivery_id',$filters['delivery_id']);
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
            $query->whereBetween('created_at', $dates);
        }
        return $query;
    }

}
