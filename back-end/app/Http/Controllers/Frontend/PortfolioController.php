<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePortfolioRequest;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Portfolio.index');
    }
    public function dataTable()
    {
        $list=Portfolio::orderBy('created_at','desc')->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($list,'get website slider list');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Portfolio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePortfolioRequest $request)
    {
        $portfolio=Portfolio::create([
            'ar'        =>[
                'name'      =>$request->ar['name'],
                'desc'      =>$request->ar['desc'],
            ],

            'en'        =>[
                'name'      =>$request->en['name'],
                'desc'      =>$request->en['desc'],
            ],
            'visible'       =>$request->visible=='on',

        ]);
        $msg=__('frontend.uploadImageOf').$portfolio->name;
        $input=['name'=>'portfolio_id','value'=>$portfolio->id];
        $files=['max'=>1,'mimes'=>".jpeg,.jpg,.png"];
        $uploadRoute=route('portfolio.uploadImg');
        $backRoute=route('portfolio.index');
        return redirect(route('uploads.index',compact('input','files','msg','uploadRoute','backRoute')))->with('success',__('frontend.itemCreated'));
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
     * @param  Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit( Portfolio  $portfolio)
    {
        return view('Portfolio.edit',compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(CreatePortfolioRequest $request,  Portfolio  $portfolio)
    {
        $portfolio->update([
            'ar'        =>[
                'name'      =>$request->ar['name'],
                'desc'      =>$request->ar['desc'],
            ],

            'en'        =>[
                'name'      =>$request->en['name'],
                'desc'      =>$request->en['desc'],
            ],
            'visible'    =>$request->visible=='on',
        ]);
        return redirect()->route('portfolio.index')->with('success',__('frontend.itemUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param   Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy( Portfolio  $portfolio)
    {
        $portfolio->delete();
        return $this->sendResponse([],'portfolio item deleted');
    }

    public function uploadImg(Request $request){
        $request->validate([
            'file'             => 'required|mimes:png,jpg,jpeg,pdf|max:3072',
            'portfolio_id'     => 'required|numeric',
        ]);
        $portfolio=Portfolio::findOrFail($request->portfolio_id);
        $image = $request->file('file');
        $imageName = time().'.'.$image->extension();
        $filePath='images/portfolio';
        $image->move(public_path($filePath),$imageName);
        $portfolio->update([
            'img'=>"$filePath/$imageName"
        ]);
        return response()->json(['success'=>$imageName]);
    }
    public function toggle(Request $request){
        $request->validate([
            'portfolio_id'     => 'required|numeric',
        ]);
        $portfolio=Portfolio::findOrFail($request->portfolio_id);
        $portfolio->update([
            'visible'   => !$portfolio->visible
        ]);
        return $this->sendResponse([],__('frontend.sliderStatus'.$portfolio->visible));
    }

}
