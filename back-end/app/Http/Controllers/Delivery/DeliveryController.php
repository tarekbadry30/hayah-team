<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\CreateDeliverRequest;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Delivery.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Delivery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDeliverRequest $request)
    {
        Delivery::create([
            'name'          => $request->name,
            'phone'         => $request->phone,
            'vehicle_number'=> $request->vehicle_number,
            'national_number'=> $request->national_number,
            'status'        => $request->status,
            'password'      => Hash::make($request->password),
            'admin_id'      => $request->admin_id,
        ]);
        return redirect(route('deliveries.index'))->with('success',__('frontend.itemCreated'));

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
     * @param  Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery  $delivery)
    {

        return view('Delivery.edit',compact('delivery'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(CreateDeliverRequest $request, Delivery  $delivery)
    {
        $delivery->update([
            'name'          => $request->name,
            'phone'         => $request->phone,
            'vehicle_number'=> $request->vehicle_number,
            'national_number'=> $request->national_number,
            'status'        => $request->status,
            'password'      => isset($request->password)?Hash::make($request->password):$delivery->password,
            'admin_id'      => auth('admin')->id(),
        ]);
        return redirect(route('deliveries.index'))->with('success',__('frontend.itemUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery  $delivery)
    {
        $delivery->delete();
        return $this->sendResponse([],'delivery deleted success');
    }

    public function dataTable()
    {
        $users=Delivery::paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($users,'get deliveries paginate');
    }
}
