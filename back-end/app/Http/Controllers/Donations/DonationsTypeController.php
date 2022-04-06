<?php

namespace App\Http\Controllers\Donations;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationTypeRequest;
use App\Models\DonationType;
use Illuminate\Http\Request;

class DonationsTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view('DonationType.index');
    }

    public function dataTable()
    {
        $options=DonationType::withCount('categories')->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($options,'get donations types paginate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('DonationType.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DonationTypeRequest $request)
    {
       $donation=DonationType::create([
            'ar'        =>[
                'name'      =>$request->ar['name'],
                'desc'      =>$request->ar['desc'],
            ],
            'en'        =>[
                'name'      =>$request->en['name'],
                'desc'      =>$request->en['desc'],
            ],
            'status'    =>$request->status,
            'admin_id'  =>auth()->guard('admin')->id()

        ]);
        $msg=__('frontend.uploadImageOf').$donation->name;
        $input=['name'=>'donation_type_id','value'=>$donation->id];
        $files=['max'=>1,'mimes'=>".jpeg,.jpg,.png"];
        $uploadRoute=route('donation-types.uploadImg');
        $backRoute=route('donation-types.index');
        //return view('fileUpload',compact('input','files','msg','uploadRoute','backRoute'))->with('success',__('frontend.itemCreated'));

        return redirect(route('uploads.index',compact('input','files','msg','uploadRoute','backRoute')))->with('success',__('frontend.itemCreated'));

        return redirect(route('donation-types.index'))->with('success',__('frontend.itemCreated'));
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
     * @param  DonationType  $donationType
     * @return \Illuminate\Http\Response
     */
    public function edit(DonationType  $donationType)
    {
        return  view('DonationType.edit',compact('donationType'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  DonationType  $donationType
     * @return \Illuminate\Http\Response
     */
    public function update(DonationTypeRequest $request, DonationType  $donationType)
    {
        $donationType->update([
            'ar'        =>[
                'name'      =>$request->ar['name'],
                'desc'      =>$request->ar['desc'],
            ],
            'en'        =>[
                'name'      =>$request->en['name'],
                'desc'      =>$request->en['desc'],
            ],
            'status'    =>$request->status,
            'admin_id'  =>auth()->guard('admin')->id()

        ]);
        return redirect(route('donation-types.index'))->with('success',__('frontend.itemUpdated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DonationType  $donationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(DonationType  $donationType)
    {
        $donationType->delete();
        return redirect(route('donation-types.index'))->with('success',__('frontend.itemDeleted'));

    }

    public function uploadImg(Request $request){
        $request->validate([
            'file'            => 'required|mimes:png,jpg,jpeg,pdf|max:3072',
            'donation_type_id'=> 'required|numeric',
        ]);
        $food=DonationType::findOrFail($request->donation_type_id);
        $image = $request->file('file');

        $imageName = time().'.'.$image->extension();
        $filePath='images/donations-types';
        $image->move(public_path($filePath),$imageName);
        $food->update([
            'img'=>"$filePath/$imageName"
        ]);
        return response()->json(['success'=>$imageName]);
    }

}
