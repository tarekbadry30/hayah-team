<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Portfolio;
use App\Models\Setting;
use App\Models\Settings\ContactPhone;
use App\Models\WebsiteSlider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(){
        $phones=ContactPhone::all();
        $settings=Setting::first();
        $sliders=WebsiteSlider::where('visible',1)->get();
        $portfolios=Portfolio::where('visible',1)->get();
        return view('FrontWebsite.index',compact('phones','settings','sliders','portfolios'));

    }
    public function portfolioShow(Portfolio $portfolio){
        return view('Portfolio.show',compact('portfolio'));
    }
}
