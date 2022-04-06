<?php

namespace App\Http\Controllers\DontationHelp;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Donation;
use App\Models\DonationHelp;
use App\Models\DonationHelpAsk;
use Illuminate\Http\Request;

class DonationHelpAsksController extends Controller
{
    public function index(){
        $deliveries=Delivery::get(['id','name']);
        return view('DonationHelp.asks',compact('deliveries'));
    }
    public function dataTable()
    {
        $donationHelps=DonationHelpAsk::with([
            'user',
            'donationHelp',
            'category',
            'type',
            'delivery',
        ])->customFilter(\request()->filters)->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($donationHelps,'get donationHelps paginate');
    }

    public function accept(Request $request)
    {
        $request->validate([
            'delivery_id'   =>'required',
            'ask_id'        =>'required',

        ]);
        $donation=DonationHelpAsk::with('donationHelp')->findOrFail($request->ask_id);
        if($donation->status!='pending'){
            return $this->sendError('donation status = '.$donation->status,[],400);
        }
        $donation->update([
            'notes'         => $request->notes,
            'delivery_id'   => $request->delivery_id,
            'admin_id'      => auth('admin')->id(),
            'status'    => 'assigned'
        ]);
        return $this->sendResponse($donation,'order assigned to delivery success');

    }

    public function refuse(Request $request)
    {
        $donation=DonationHelpAsk::with('donationHelp')->findOrFail($request->ask_id);
        if($donation->status!='pending'){
            return $this->sendError('donation status = '.$donation->status,[],400);
        }
        $donation->update([
            'status'        => 'admin_refused'
        ]);
        $donation->donationHelp()->update([
            'asked'    =>   false
        ]);
        return $this->sendResponse([],'donation refused success');

    }}
