<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodCart extends Model
{
    use HasFactory;
    protected $with=['food'];
    protected $guarded=[];
    public function food(){
        return $this->belongsTo(Food::class,'food_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
