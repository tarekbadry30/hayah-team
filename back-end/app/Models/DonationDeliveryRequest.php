<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationDeliveryRequest extends Model
{
    use HasFactory;
    // collect donation from team  and send to users
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function delivery(){
        return $this->belongsTo(Delivery::class,'delivery_id');
    }
    public function request(){
        return $this->belongsTo(DonationRequest::class,'request_id');
    }
}
