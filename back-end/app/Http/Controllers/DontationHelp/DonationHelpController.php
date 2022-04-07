<?php

namespace App\Http\Controllers\DontationHelp;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationHelpRequest;
use App\Models\Delivery;
use App\Models\DonationHelp;
use App\Models\Food;
use Illuminate\Http\Request;

class DonationHelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('DonationHelp.index');
    }
    public function dataTable()
    {
        $donationHelps=DonationHelp::with([
            'category',
            'donationType',
        ])->customFilter(\request()->filters)->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($donationHelps,'get donationHelps paginate');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('DonationHelp.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DonationHelpRequest $request)
    {
        $donationHelp=DonationHelp::create([
            'category_id'   => $request->category_id,
            'type_id'       => $request->type_id,
            'ar'            =>[
                'name'      =>$request->ar['name'],
                'desc'      =>$request->ar['desc'],
            ],
            'en'            =>[
                'name'      =>$request->en['name'],
                'desc'      =>$request->en['desc'],
            ],
            'admin_id'      =>auth('admin')->user()->id,
        ]);
        $msg=__('frontend.uploadImageOf').$donationHelp->name;
        $input=['name'=>'donation_help_id','value'=>$donationHelp->id,'model'=>DonationHelp::class];
        $files=['max'=>1,'mimes'=>".jpeg,.jpg,.png"];
        $uploadRoute=route('donation-helps.uploadImg');
        $backRoute=route('donation-helps.index');
        return redirect(route('uploads.index',compact('input','files','msg','uploadRoute','backRoute')))->with('success',__('frontend.itemCreated'));

    }

    public function uploadImg(Request $request){
        $request->validate([
            'file'          => 'required|mimes:png,jpg,jpeg,pdf|max:3072',
            'donation_help_id'   => 'required|numeric',
        ]);
        $donationHelp=DonationHelp::findOrFail($request->donation_help_id);
        $image = $request->file('file');

        $imageName = time().'.'.$image->extension();
        $filePath='images/donations-help';
        $image->move(public_path($filePath),$imageName);
        $donationHelp->update([
            'img'=>"$filePath/$imageName"
        ]);
        return response()->json(['success'=>$imageName]);
    }
    /**
     * Display the specified resource.
     *
     * @param  DonationHelp  $donationHelp
     * @return \Illuminate\Http\Response
     */
    public function show(DonationHelp  $donationHelp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  DonationHelp  $donationHelp
     * @return \Illuminate\Http\Response
     */
    public function edit(DonationHelp $donationHelp)
    {
        //$donationHelp= DonationHelp::findOrFail($donationHelp);
        return view('DonationHelp.edit',compact('donationHelp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  DonationHelp  $donationHelp
     * @return \Illuminate\Http\Response
     */
    public function update(DonationHelpRequest $request, DonationHelp  $donationHelp)
    {
        $donationHelp->update([
            'category_id'   => $request->category_id,
            'type_id'       => $request->type_id,
            'ar'            =>[
                'name'      =>$request->ar['name'],
                'desc'      =>$request->ar['desc'],
            ],
            'en'            =>[
                'name'      =>$request->en['name'],
                'desc'      =>$request->en['desc'],
            ],
            'admin_id'      =>auth('admin')->user()->id,
        ]);
        return redirect(route('donations-help.index'))->with('success',__('frontend.itemUpdated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DonationHelp  $donationHelp
     * @return \Illuminate\Http\Response
     */
    public function destroy(DonationHelp $donationHelp)
    {
        $donationHelp->delete();
        return $this->sendResponse(['donationHelp'=>$donationHelp],__('frontend.itemDeleted'));
    }

}
