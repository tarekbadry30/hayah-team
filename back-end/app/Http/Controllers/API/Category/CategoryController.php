<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResouce;
use App\Http\Resources\DonationTypeResource;
use App\Http\Resources\NestedDonationTypes;
use App\Models\Category;
use App\Models\DonationType;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'type_id'=>'required'
        ]);
        $list=Category::where([
            ['type_id',$request->type_id],
            ['status','enabled']
        ])->get();
        //$category=Category::whereNull('parent_id')->get();
        return CategoryResouce::collection($list);
    }
    public function urgent()
    {
        $types=Category::where([
            ['status','enabled'],
            ['urgent',1],
        ])->get();
        //$category=Category::whereNull('parent_id')->get();
        return CategoryResouce::collection($types);
    }
    public function all(Request $request)
    {
        $list=DonationType::get();
        //$category=Category::whereNull('parent_id')->get();
        return NestedDonationTypes::collection($list);
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
