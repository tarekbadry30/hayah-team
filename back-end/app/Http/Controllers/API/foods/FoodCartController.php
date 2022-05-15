<?php

namespace App\Http\Controllers\API\foods;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\FoodCartRequest;
use App\Http\Requests\API\RemoveCartItemRequest;
use App\Http\Resources\CartResource;
use App\Models\FoodCart;
use Illuminate\Http\Request;

class FoodCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list=FoodCart::with('food')->where('user_id',auth('sanctum')->id())->get();
        return CartResource::collection($list);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodCartRequest $request)
    {
        $cart=FoodCart::firstOrCreate([
            'food_id'   =>  $request->food_id,
            'user_id'   =>  auth('sanctum')->id(),
        ]);

        if($cart->amount!=$request->amount) {
            $cart->amount = $request->amount;
            $cart->save();
        }
        return $this->sendResponse([],'food cart updated');
    }
    public function remove(RemoveCartItemRequest $request)
    {
        $cart = FoodCart::where([
            'food_id' => $request->food_id,
            'user_id' => auth('sanctum')->id(),
        ])->first();

        if (isset($cart)) {
            $cart->delete();
            return $this->sendResponse([], 'cart item deleted');
        } else {
            return $this->sendError([],'cart item not found',404);

        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clear()
    {
        auth('sanctum')->user()->clearCart();
        return $this->sendResponse([],'food cart cleared');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FoodCart  $foodCart
     * @return \Illuminate\Http\Response
     */
    public function show(FoodCart $foodCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FoodCart  $foodCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FoodCart $foodCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FoodCart  $foodCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(FoodCart $foodCart)
    {
        //
    }
}
