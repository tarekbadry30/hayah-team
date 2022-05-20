<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationDeliveryOrder extends Model
{

    // get donation from users and send to team
    use HasFactory;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function delivery(){
        return $this->belongsTo(Delivery::class,'delivery_id');
    }
    public function donation(){
        return $this->belongsTo(Donation::class,'donation_id');
    }
    public function option(){
        return $this->belongsTo(CategoryOption::class,'option_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function donationType(){
        return $this->belongsTo(DonationType::class,'type_id');
    }
}
