<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationHelpAsk extends Model
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
    public function donationHelp(){
        return $this->belongsTo(DonationHelp::class,'donation_help_id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function type(){
        return $this->belongsTo(DonationType::class,'type_id');
    }

    public function scopeCustomFilter($query,$filters){
        if(isset($filters['type_id']))
            $query->where('type_id',$filters['type_id']);
        if(isset($filters['category_id']))
            $query->where('category_id',$filters['category_id']);
        if(isset($filters['status']))
            $query->where('status',$filters['status']);
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
            /*echo json_encode($dates);
            die();*/
            $query->whereBetween('created_at', $dates);
        }
        return $query;
    }

}