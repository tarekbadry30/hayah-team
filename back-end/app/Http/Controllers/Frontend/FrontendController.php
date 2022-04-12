<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Setting;
use App\Models\Settings\ContactPhone;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(){
        $phones=ContactPhone::all();
        $settings=Setting::first();
        return view('FrontWebsite.index',compact('phones','settings'));

    }
}
