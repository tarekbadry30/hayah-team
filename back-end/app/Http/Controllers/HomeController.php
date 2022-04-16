<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Delivery;
use App\Models\Donation;
use App\Models\DonationHelp;
use App\Models\DonationHelpAsk;
use App\Models\DonationType;
use App\Models\FinanceDonation;
use App\Models\Food;
use App\Models\FoodRequest;
use App\Models\FormSheet;
use App\Models\Portfolio;
use App\Models\ShareIdea;
use App\Models\Slider;
use App\Models\User;
use App\Models\WebsiteSlider;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function Dashboard(){
        $cards=[];
        $statics=[
            User::class,
            DonationType::class,
            Category::class,
            Donation::class,
            FinanceDonation::class,
            Delivery::class,
            Food::class,
            FoodRequest::class,
            DonationHelp::class,
            DonationHelpAsk::class,
            FormSheet::class,
            ShareIdea::class,
            ContactUs::class,
            WebsiteSlider::class,
            Portfolio::class,

        ];
        foreach ($statics as $item) {
            $itemObj=(new $item);
            $tableName=str_replace('_','-',$itemObj->getTable());
            $cards[] = [
                'name' => __('frontend.' . $tableName.'List'),
                'value' => $item::count(),
                'route' => Route::has($tableName . '.index')?route($tableName . '.index'):(Route::has($tableName . 's.index')?route($tableName . 's.index'):'#')
            ];
        }
        //dd((new DonationHelpAsk())->getTable());
        /*$cardItem=[
            'name'  =>  __('frontend.users'),
            'value' =>  User::count(),
            'route' =>  route('users.index')
        ];
        $cards[]=$cardItem;*/


        return view('Dashboard.index',compact('cards'));
    }
}
