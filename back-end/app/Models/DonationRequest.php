<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    /*public function delivery(){
        return $this->belongsToMany(Delivery::class,()->getTable(),'delivery_id',);
    }*/
    public function delivery(){
        return $this->belongsTo(Delivery::class,'delivery_id');
    }

}
