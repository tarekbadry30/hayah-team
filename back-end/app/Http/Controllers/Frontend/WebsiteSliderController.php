<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSlider;
use Illuminate\Http\Request;

class WebsiteSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('WebsiteSlider.index');
    }
    public function dataTable()
    {
        $list=WebsiteSlider::orderBy('created_at','desc')->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($list,'get website slider list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('uploads.index',['model'=>'WebsiteSlider']);
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
        $filePath='images/website-slider';
        $image->move(public_path($filePath),$imageName);
        $websiteSlider=WebsiteSlider::create([
            'img'=>"$filePath/$imageName"
        ]);
        return response()->json(['success'=>$imageName]);
    }
    public function toggle(Request $request){
        $request->validate([
            //'file'  => 'required|mimes:png,jpg,jpeg,pdf|max:3072',
            'slider_id'     => 'required|numeric',
        ]);
        $websiteSlider=WebsiteSlider::findOrFail($request->slider_id);
        $websiteSlider->update([
            'visible'   => !$websiteSlider->visible
        ]);
        return $this->sendResponse([],__('frontend.sliderStatus'.$websiteSlider->visible));
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
     * @param  WebsiteSlider  $websiteSlider
     * @return \Illuminate\Http\Response
     */
    public function destroy(WebsiteSlider  $websiteSlider)
    {
        $websiteSlider->delete();
        return $this->sendResponse([],'slider image deleted');

    }
}
