<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinksRequest;
use App\Models\Link;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Link.index');
    }
    public function dataTable()
    {
        $list=Link::paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($list,'get links list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types=['facebook','twitter','instagram','snapchat','youtube','website','other'];
        return view('Link.create',compact('types'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LinksRequest $request)
    {
        Link::create([
            'ar'        =>[
                'name'      =>$request->ar['name'],
            ],

            'en'        =>[
                'name'      =>$request->en['name'],
            ],
            'type'=>$request->type,

            'link'=>$request->link
        ]);
        return redirect()->route('settings.links.index')->with('success',__('frontend.itemCreated'));
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
     * @param  Link  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link  $link)
    {
        //return $link;
        $types=['facebook','twitter','instagram','snapchat','youtube','website','other'];
        return view('Link.edit',compact('link','types'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Link  $link
     * @return \Illuminate\Http\Response
     */
    public function update(LinksRequest $request, Link  $link)
    {
        $link->update([
            'ar'        =>[
                'name'      =>$request->ar['name'],
            ],

            'en'        =>[
                'name'      =>$request->en['name'],
            ],
            'type'=>$request->type,
            'link'=>$request->link
        ]);
        return redirect()->route('settings.links.index')->with('success',__('frontend.itemUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Link  $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link  $link)
    {
        $link->delete();
        return $this->sendResponse([],__('frontend.itemDeleted'));
    }
}
