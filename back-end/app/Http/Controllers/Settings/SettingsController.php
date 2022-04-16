<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactInfo;
use App\Http\Resources\SettingResource;
use App\Models\ContactEmail;
use App\Models\Donation;
use App\Models\DonationHelp;
use App\Models\FinanceDonation;
use App\Models\Food;
use App\Models\Link;
use App\Models\Setting;
use App\Models\Settings\ContactPhone;
use App\Models\User;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('settings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function forApi(){
        $setting=Setting::first();
        return new SettingResource($setting);
    }
    public function statistics(){
        $usersCount=User::count();
        $thingsDonation=Donation::count();
        $moneyDonation=FinanceDonation::count();
        $totalMoney=FinanceDonation::where('status','completed')->sum('value');
        $helps=DonationHelp::count();
        $foods=Food::count();
        $data=[
            'users'=>$usersCount,
            'physical_donation'=>$thingsDonation,
            'financial_donation'=>$moneyDonation,
            'total_money'=>$totalMoney,
            'helps'=>$helps,
            'foods'=>$foods
        ];
        return  $this->sendResponse($data,'get statistics');
    }
    public function contactInfo(){
        $phones=ContactPhone::all();
        $emails=ContactEmail::all();
        $links=Link::all();

        $setting=new Setting();
        $setting->phones=$phones;
        $setting->emails=$emails;
        $setting->links=$links;
        return new ContactInfo($setting);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $setting=Setting::first();
        return view('settings.edit',compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Setting  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Setting $setting)
    {
        $setting->update([
            'name'          =>$request->name,

            'ar'        =>[
                'about'      =>$request->ar['about'],
                'vision'     =>$request->ar['vision'],
                'goals'      =>$request->ar['goals'],
            ],

            'en'        =>[
                'about'      =>$request->en['about'],
                'vision'     =>$request->en['vision'],
                'goals'      =>$request->en['goals'],
            ],
        ]);
        return redirect()->route('settings.index')->with('success',__('frontend.settingsUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
