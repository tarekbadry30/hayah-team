<?php

namespace App\Http\Controllers\API\Delivery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\AcceptOrder;
use App\Http\Resources\DeliveryHelpAskResource;
use App\Models\DonationHelpAsk;
use Illuminate\Http\Request;

class DeliveryHelpAskController extends Controller
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
        $statuses=[
        'assigned',
        'delivery_accepted',
        'delivery_refused',
        'in_way',
        'completed',];
        if(!in_array($request->status,$statuses))
            return $this->sendError('status value must be one of ['." 'assigned', 'delivery_accepted', 'delivery_refused', 'in_way', 'completed']",[],401);
        $orders=DonationHelpAsk::with([
            'donationHelp',
            'type',
            'category',
            'user',
        ])->where([['status',$request->status],['delivery_id',auth()->guard('delivery_api')->id()]])->get();
        return DeliveryHelpAskResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AcceptOrder $request)
    {
        $order=DonationHelpAsk::findOrFail($request->order_id);
        if(!in_array($request->get('status'),['in_way','delivery_accepted','delivery_refused','completed']))
            return $this->sendError('status value must be one of ['." 'delivery_accepted', 'delivery_refused', 'in_way', 'completed']",[],401);
        if($order->status==$request->get('status')){
            return $this->sendError('current order status = "'.$order->status .'" try another status',[],401);
        }
        if($order->delivery_id!=auth()->guard('delivery_api')->id()){
            return $this->sendError('unUnauthorized action',[],401);
        }

        $order->update([
            'status'=>$request->get('status')
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
