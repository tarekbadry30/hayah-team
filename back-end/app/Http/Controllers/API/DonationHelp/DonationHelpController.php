<?php

namespace App\Http\Controllers\API\DonationHelp;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateDonationHelpRequest;
use App\Http\Resources\DonationHelpResource;
use App\Models\DonationHelp;
use App\Models\DonationHelpAsk;
use Illuminate\Http\Request;

class DonationHelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donationsHelp=DonationHelp::with([
            'category',
            'donationType',
        ])->where('available',true)->get();
        return DonationHelpResource::collection($donationsHelp);//->additional(['current_help_month' => $month]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDonationHelpRequest $request)
    {
        $donation=DonationHelp::findOrFail($request->id);
        if(!$donation->available||$donation->asked)
            return $this->sendError('can not make this request now \n try again later',[],401);
        DonationHelpAsk::firstOrCreate([
            'user_id'           =>  auth('sanctum')->id(),
            'donation_help_id'  =>  $request->id,
            'category_id'       =>  $donation->category_id,
            'type_id'           =>  $donation->type_id,
        ]);
        $donation->update([
            'asked'=>true
        ]);
        return $this->sendResponse('request assigned success',200);
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
