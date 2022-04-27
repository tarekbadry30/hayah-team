<?php

namespace App\Http\Controllers\ContactUs;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ContactUs.index');
    }

    public function dataTable()
    {
        $messages=ContactUs::orderBy('id','desc')->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($messages,'get messages paginate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contactUs=ContactUs::findOrFail($id)->delete();
        //$contactUs->delete();
        return $this->sendResponse([],__('frontend.itemDeleted'));
    }

    public function receiveMessage(Request $request){
        $request->validate([
            'name'      =>  'required|string|min:3',
            'email'     =>  'required|email',
            'phone'     =>  'required|string|min:3',
            'message'   =>  'required|string|min:3',
        ]);
        ContactUs::create([
            'name'      =>$request->name,
            'email'     =>$request->email,
            'phone'     =>$request->phone,
            'message'   =>$request->message,
        ]);
        return $this->sendResponse([],__('website.messageReceived'));

    }
    public function export(Request $request){
        $list=ContactUs::all();
        return \fastexcel($list)->download('contactUsMessages.xlsx',function ($line) {
            //dd($line);
            return [
                'name' => $line['name'],
                'email' => $line['email'],
                'phone' => $line['phone'],
                'message' => $line['message'],
                'date'=>$line['created_at'],
            ];
        });
        //return (new FastExcel($foods))->export('foods.xlsx');
    }


}
