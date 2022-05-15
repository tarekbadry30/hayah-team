<?php

namespace App\Http\Controllers\API\foods;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateFoodRequest;
use App\Http\Resources\FoodsResouce;
use App\Models\Food;
use App\Models\FoodRequest;
use App\Models\UserMonthFood;
use App\Models\UserMonthHelp;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods=Food::where('available',true)->get();
        $month=UserMonthHelp::where([
            ['month',Carbon::now()->format('Y-m').'-01 00:00:00'],
            ['user_id',auth('sanctum')->id()]
        ])->first(['id','month','help_value','remaining_value','total_value']);

        return FoodsResouce::collection($foods)->additional(['current_help_month' => $month]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $totalPrice=0;
        $cart=auth('sanctum')->user()->cart;
        if(count($cart)<1)
            return $this->sendError('cart empty please select one item at least',[],400);

        foreach ($cart as $cartItem) {
            if(!$cartItem->food->available)
                return $this->sendError('this food item not available now',['foodItem'=>$cartItem->food],400);
            $totalPrice+=($cartItem->food->price*$cartItem->amount);
        }
        $month=UserMonthHelp::where([
            ['user_id',auth('sanctum')->id()],
            ['month',Carbon::now()->format('Y-m').'-01 00:00:00'],
        ])->first();
        if(!isset($month))
            return $this->sendError('user not have balance this month',['current_month'=>Carbon::now()->format('Y-m')],404);
        if($month->remaining_value<$totalPrice)
            return $this->sendError('Your current balance is not enough.',[
                'current_balance'   =>$month->remaining_value,
                'needed_balance'    =>$totalPrice-$month->remaining_value,
                'total_price'       =>$totalPrice,
            ],401);
        $foodRequest=FoodRequest::create([
            'month_id'     =>  $month->id,
            'user_id'      =>  auth('sanctum')->id(),
            'total_value'  =>  $totalPrice,
        ]);
        foreach ($cart as $cartItem) {
            UserMonthFood::create([
                'user_id'   => auth('sanctum')->id(),
                'month_id'  => $month->id,
                'food_id'   => $cartItem->food->id,
                'request_id' => $foodRequest->id,
                'price' => $cartItem->food->price,
                'count' => $cartItem->amount,
                'total' => $cartItem->amount * $cartItem->food->price,
            ]);

        }
        $month->remaining_value=$month->remaining_value-$totalPrice;
        $month->save();
        auth('sanctum')->user()->clearCart();
        return $this->sendResponse([],'monthly food request created waiting admin to confirm');
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
