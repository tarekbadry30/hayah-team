<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Setting extends Model
{
    use HasFactory;
    public function getGoalsAttribute(){
        $goal='goals_'.LaravelLocalization::getCurrentLocale();
        return $this->$goal;
    }
    public function getVisionAttribute(){
        $goal='vision_'.LaravelLocalization::getCurrentLocale();
        return $this->$goal;
    }
}
