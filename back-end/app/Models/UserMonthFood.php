<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMonthFood extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with=['food'];
    public function request(){
        return $this->belongsTo(FoodRequest::class,'request_id');
    }
    public function food(){
        return $this->belongsTo(Food::class,'food_id');
    }
}
