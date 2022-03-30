<?php

namespace App\Http\Controllers\Donations;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Donation;
use App\Models\DonationType;
use Illuminate\Http\Request;

class DonationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::where('status','active')->get(['id','name']);
        return view('Donation.index',compact('deliveries'));
    }


    public function dataTable()
    {
        $options=Donation::with(['category','user','option','donationType'])->customFilter(\request()->filters)->orderBy('created_at','desc')->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($options,'get donations paginate');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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


    public function acceptDonation(Request $request)
    {
        $donation=Donation::findOrFail($request->donation_id);
        if($donation->status!='pending'){
            return $this->sendError('donation status = '.$donation->status,[],400);
        }
        $donation_order = $donation->assignDelivery($request->delivery_id,$request->notes);
        return $this->sendResponse($donation_order,'order assigned to delivery success');

    }
}
