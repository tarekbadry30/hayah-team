<?php

namespace App\Http\Controllers\API\Delivery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\AcceptOrder;
use App\Http\Resources\API\DeliveryOrder;
use App\Models\DonationDeliveryOrder;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'status'    =>  'required|string'
        ]);
        if(!in_array($request->status,['pending','admin_refused','assigned','delivery_accepted','delivery_refused','completed']))
            return $this->sendError('status value must be one of ['." 'pending', 'delivery_accepted', 'delivery_refused', 'in_way', 'completed']",[],401);
        $orders=DonationDeliveryOrder::with([
            'donation.donationType',
            'donation.option',
            'donation.category',
            'user',

])
            //->where('status',$request->status)->get();
            ->where([['status',$request->status],['delivery_id',auth()->guard('delivery_api')->id()]])->get();
        return DeliveryOrder::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AcceptOrder $request)
    {
        $order=DonationDeliveryOrder::findOrFail($request->order_id);
        if(!in_array($request->status,['in_way','delivery_accepted','delivery_refused','completed']))
            return $this->sendError('status value must be one of ['." 'delivery_accepted', 'delivery_refused', 'in_way', 'completed']",[],401);
        if($order->status==$request->status){
            return $this->sendError('current order status = '.$order->status,[],401);
        }
        $order->update([
            'status'=>$request->status
        ]);
        if(in_array($order->status,['delivery_accepted','delivery_refused','completed']))
        $order->donation->update([
            'status'=> $order->status
        ]);
        return $this->sendResponse("order status = $order->status",'order status updated');
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
