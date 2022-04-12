<?php

namespace App\Http\Controllers\API\FormSheet;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormSheetUserAnswerRequest;
use App\Http\Resources\FormSheetResouce;
use App\Models\FormSheet;
use App\Models\FormSheetAnswerInput;
use App\Models\FormSheetUserAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FormSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $now=Carbon::now()->format('Y-m-d H:i:s');
        if(isset($request->limit)&&is_int($request->limit))
            $list=FormSheet::with('inputs')->where([
                ['to','>',$now],
                ['visible',1]
            ])->orWhere([
                ['to',null],
                ['visible',1]
            ])->orderBy('to','desc')->limit($request->limit)->get();
        else
            $list=FormSheet::with('inputs')->where([
                ['to','>',$now],
                ['visible',1]
            ])->orWhere([
                ['to',null],
                ['visible',1]
            ])->orderBy('to','desc')->get();
        $list->each->setTranslated(['ar','en']);
        return FormSheetResouce::collection($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormSheetUserAnswerRequest $request)
    {
        $user_id=auth('sanctum')->id();
        $formAnswer=FormSheetUserAnswer::create([
            'user_id'       =>  $user_id,
            'form_sheet_id' =>  $request->form_id,
        ]);
        foreach ($request->answers as $answer)
            //return$answer['answer'];
            FormSheetAnswerInput::create([
                'user_id'           =>$user_id,
                'form_sheet_id'     =>$request->form_id,
                'input_id'          =>$answer['input_id'],
                'answer_id'         =>$formAnswer->id,
                'answer'            =>$answer['answer'],
            ]);
        return $this->sendResponse([],'form answer created');
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
        //
    }
}
