<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\FoodRequest;
use App\Models\User;
use Illuminate\Http\Request;

class FoodRequestsConroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::where('status','active')->get(['id','name']);
        $user=null;
        if(\request()->user_id){
            $user=User::findOrFail(\request()->user_id);
        }
        return view('FoodRequest.index',compact('deliveries','user'));
    }

    public function dataTable()
    {
        $options=FoodRequest::with(['admin','user','month','delivery'])->customFilter(\request()->filters)->orderBy('created_at','desc')->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($options,'get foods request paginate');
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
     * @param  FoodRequest  $foodRequest
     * @return \Illuminate\Http\Response
     */
    public function show(FoodRequest  $foodRequest)
    {
        return view('FoodRequest.show',compact('foodRequest'));
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

    public function accept(Request $request)
    {
        $foodRequest=FoodRequest::findOrFail($request->request_id);
        if($foodRequest->status!='pending'){
            return $this->sendError('request status = '.$foodRequest->status,[],400);
        }
        $foodRequest->update([
            'status'        =>'assigned',
            'delivery_id'   =>$request->delivery_id,
            'admin_id'      =>auth('admin')->id(),
            //'notes'         =>$request->notes
        ]);
        return $this->sendResponse([],'order assigned to delivery success');

    }

    public function refuse(Request $request)
    {

        $foodRequest=FoodRequest::findOrFail($request->request_id);
        if($foodRequest->status!='pending'){
            return $this->sendError('request status = '.$foodRequest->status,[],400);
        }
        $foodRequest->update([
            'status'        =>'admin_refused',
            'admin_id'      =>auth('admin')->id(),
            //'delivery_id'   =>$request->delivery_id,
            //'notes'         =>$request->notes
        ]);
        return $this->sendResponse([],'order refused success');
    }
}
