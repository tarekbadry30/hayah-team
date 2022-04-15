<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSheetUserAnswer extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts = [
        'created_at'  => 'datetime:Y-m-d h:i:s a',
    ];
    public function inputAnswers(){
        return $this->hasMany(FormSheetAnswerInput::class,'answer_id')->orderBy('input_id','asc');

    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');

    }
}
