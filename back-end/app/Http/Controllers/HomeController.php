<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\Donation;
use App\Models\DonationType;
use App\Models\User;
use Illuminate\Http\Request;

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
            Delivery::class,

        ];
        foreach ($statics as $item) {
            $tableName=str_replace('_','-',(new $item)->getTable());
            $cards[] = [
                'name' => __('frontend.' . $tableName.'List'),
                'value' => $item::count(),
                'route' => route($tableName . '.index')
            ];
        }
        /*$cardItem=[
            'name'  =>  __('frontend.users'),
            'value' =>  User::count(),
            'route' =>  route('users.index')
        ];
        $cards[]=$cardItem;*/


        return view('Dashboard.index',compact('cards'));
    }
}
