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
    public function receiveMessage(Request $request){
        $request->validate([
            'name'      =>  'required|string|min:3',
            'email'     =>  'required|email',
            'phone'     =>  'required|string|min:3',
            'message'   =>  'required|string|min:3',
        ]);
        ContactUs::create([
            'name'      =>$request->name,
            'email'     =>$request->email,
            'phone'     =>$request->phone,
            'message'   =>$request->message,
        ]);
        return $this->sendResponse([],__('website.messageReceived'));

    }
}
