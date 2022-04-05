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
        DonationType::create([
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
        return redirect(route('donation-types.index'))->with('success',__('frontend.updatedDeleted'));

    }
}
