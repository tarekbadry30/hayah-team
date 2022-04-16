<?php

namespace App\Http\Controllers\SharedIdea;

use App\Http\Controllers\Controller;
use App\Http\Requests\SharedIdeaRequest;
use App\Models\ShareIdea;
use Illuminate\Http\Request;

class SharedIdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('SharedIdea.index');
    }
    public function dataTable(){
        $options=ShareIdea::orderBy('created_at','desc')->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($options,'get shared idea paginate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('SharedIdea.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SharedIdeaRequest $request)
    {
        ShareIdea::create([
            'idea'                  =>$request->idea,
            'target_group'          =>$request->target_group,
            'execution_mechanism'   =>$request->execution_mechanism,
            'name'                  =>$request->name,
            'phone'                 =>$request->phone,
            'money'                 =>$request->money,
            'timing'                =>$request->timing,
        ]);
        return $this->sendResponse([],'new idea created');
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
     * @param  ShareIdea  $shareIdea
     * @return \Illuminate\Http\Response
     */
    public function edit(ShareIdea  $shareIdea)
    {
        return view('SharedIdea.edit',compact('shareIdea'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ShareIdea  $shareIdea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShareIdea  $shareIdea)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shareIdea=ShareIdea::findOrFail($id);
        $shareIdea->delete();
        return $this->sendResponse([],__('frontend.itemDeleted'));
    }

    public function export(){
        $list=ShareIdea::all();
        return \fastexcel($list)->download('sharedIdeas.xlsx',function ($line) {
            //dd($line);
            return [
                'idea'                  =>$line['idea'],
                'target_group'          =>$line['target_group'],
                'execution_mechanism'   =>$line['execution_mechanism'],
                'name'                  =>$line['name'],
                'phone'                 =>$line['phone'],
                'money'                 =>$line['money'],
                'timing'                =>$line['timing'],
                'date'                  =>$line['created_at'],

            ];
        });
        //return (new FastExcel($foods))->export('foods.xlsx');
    }
}
