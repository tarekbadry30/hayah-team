<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\MobileSliderResouce;
use App\Models\MobileSlider;
use Illuminate\Http\Request;

class MobileSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('MobileSlider.index');
    }
    public function dataTable()
    {
        $list=MobileSlider::orderBy('created_at','desc')->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($list,'get website slider list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('uploads.index',['model'=>'MobileSlider']);
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
    public function uploadImg(Request $request){
        $request->validate([
            'file'  => 'required|mimes:png,jpg,jpeg,pdf|max:3072',
            //'slider_id'     => 'required|numeric',
        ]);
        $image = $request->file('file');
        $imageName = time().'.'.$image->extension();
        $filePath='images/mobile-slider';
        $image->move(public_path($filePath),$imageName);
        $mobileSlider=MobileSlider::create([
            'img'=>"$filePath/$imageName"
        ]);
        return response()->json(['success'=>$imageName]);
    }
    public function toggle(Request $request){
        $request->validate([
            //'file'  => 'required|mimes:png,jpg,jpeg,pdf|max:3072',
            'slider_id'     => 'required|numeric',
        ]);
        $mobileSlider=MobileSlider::findOrFail($request->slider_id);
        $mobileSlider->update([
            'visible'   => !$mobileSlider->visible
        ]);
        return $this->sendResponse([],__('frontend.sliderStatus'.$mobileSlider->visible));
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
     * @param  MobileSlider  $mobileSlider
     * @return \Illuminate\Http\Response
     */
    public function destroy(MobileSlider  $mobileSlider)
    {
        $mobileSlider->delete();
        return $this->sendResponse([],'slider image deleted');

    }
    public function activeListAPI()
    {
        $list=MobileSlider::where('visible',1)->get();
        return MobileSliderResouce::collection($list);
        return $this->sendResponse([],'slider image deleted');

    }
}
