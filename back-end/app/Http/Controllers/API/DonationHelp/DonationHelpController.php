<?php

namespace App\Http\Controllers\API\DonationHelp;

use App\Http\Controllers\Controller;
use App\Http\Resources\DonationHelpResource;
use App\Models\DonationHelp;
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
