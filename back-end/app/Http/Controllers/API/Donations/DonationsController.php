<?php

namespace App\Http\Controllers\API\Donations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Donation\CreateDonationRequest;
use App\Models\Donation;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDonationRequest $request)
    {

        $donation=Donation::create([
            //'name'          =>'any name',
            'desc'          =>$request->desc,
            'map_location'  =>'any map_location',
            'type'          =>$request->get('type'),
            'value'         =>$request->value,
            'status'        =>$request->get('type')=='financial'?'completed':'pending',
            'option_id'     =>$request->option_id,
            'category_id'   =>$request->category_id,
            'type_id'       =>$request->type_id,
            'user_id'       =>auth()->user()->id,
            //'admin_id'=>$request->option_id,
        ]);
        if($request->get('type')=='financial')
            $donation->category->update([
                'collected_value'=>$donation->category->collected_value+$request->value
            ]);
        return $this->sendResponse([],'new donation created');
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
}
