<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactEmailRequest;
use App\Models\ContactEmail;
use Illuminate\Http\Request;

class ContactEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ContactEmail.index');
    }
    public function dataTable()
    {
        $list=ContactEmail::paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($list,'get contact emails');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ContactEmail.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactEmailRequest $request)
    {
        ContactEmail::create([
            'ar'        =>[
                'name'      =>$request->ar['name'],
            ],

            'en'        =>[
                'name'      =>$request->en['name'],
            ],
            'email'=>$request->email
        ]);
        return redirect()->route('settings.contact-emails.index')->with('success',__('frontend.itemCreated'));
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
     * @param  ContactEmail  $contactEmail
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactEmail  $contactEmail)
    {
        return view('ContactEmail.edit',compact('contactEmail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ContactEmail  $contactEmail
     * @return \Illuminate\Http\Response
     */
    public function update(ContactEmailRequest $request, ContactEmail  $contactEmail)
    {
        $contactEmail->update([
            'ar'        =>[
                'name'      =>$request->ar['name'],
            ],

            'en'        =>[
                'name'      =>$request->en['name'],
            ],
            'email'=>$request->email
        ]);
        return redirect()->route('settings.contact-emails.index')->with('success',__('frontend.itemUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ContactEmail  $contactEmail
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactEmail  $contactEmail)
    {
        $contactEmail->delete();
        return $this->sendResponse([],__('frontend.itemDeleted'));
    }
}
