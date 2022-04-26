<?php

namespace App\Http\Controllers\API\Donations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Donation\CreateDonationRequest;
use App\Models\CategoryOption;
use App\Models\Donation;
use App\Models\FinanceDonation;
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
        $option=CategoryOption::with('category.type')->findOrFail($request->option_id);
        if($option->type!='physical')
            return $this->sendError('type not accepted',['option'=>'option type must be "physical"'],401);
        Donation::create([
            //'name'          =>'any name',
            //'type'          =>$request->get('type'),
            //'value'         =>$request->value,
            //'status'        =>$request->get('type')=='financial'?'completed':'pending',
            //'admin_id'      =>$request->option_id,
            'desc'          =>$request->desc,
            'lat'           =>$request->lat,
            'long'          =>$request->long,
            'address'       =>$request->address,
            'type_id'       =>$option->category->type_id,
            'category_id'   =>$option->category_id,
            'option_id'     =>$option->id,
            'user_id'       =>auth()->user()->id,
        ]);
        return $this->sendResponse([],'new donation created');
    }

    public function createFinanceDonation(Request $request){
        $request->validate([
            'value'         =>'required|numeric',
            'option_id'     =>'required|numeric',
        ]);
        $option=CategoryOption::with('category.type')->findOrFail($request->option_id);
        if($option->type!='financial')
            return $this->sendError('type not accepted',['option'=>'option type must be "financial"'],401);
        FinanceDonation::create([
            'value'         =>$request->value,
            'operation_id'  =>$request->operation_id,
            'type_id'       =>$option->category->type_id,
            'category_id'   =>$option->category_id,
            'option_id'     =>$option->id,
            'user_id'       =>auth()->user()->id,
        ]);
        $option->category->update([
            'collected_value'=>$option->category->collected_value+$request->value
        ]);
        return $this->sendResponse([],'new finance donation created');

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
