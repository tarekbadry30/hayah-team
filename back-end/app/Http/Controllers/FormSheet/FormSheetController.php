<?php

namespace App\Http\Controllers\FormSheet;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormSheetRequest;
use App\Models\FormSheet;
use App\Models\FormSheetInput;
use App\Models\FormSheetInputTranslation;
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
    public function index()
    {
        return view('FormSheet.index');
    }
    public function dataTable(){
        $options=FormSheet::/*with(['answers','user','option','donationType'])->*/withCount(['inputs','answers'])->customFilter(\request()->filters)->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($options,'get form sheets paginate');
    }
    public function answerDataTable(){
        $answers = FormSheetUserAnswer::with(['inputAnswers','user'])->where('form_sheet_id',\request()->form_id)->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($answers,'get form sheet answers paginate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inputsCount=0;
        return view('FormSheet.create',compact('inputsCount'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FormSheetRequest $request)
    {
       // return $request;
        if(isset($request->visibleRange)) {
            if(str_contains($request->visibleRange,' to ')){
                $dates = explode(" to ", $request->visibleRange);
                $from=$dates[0].' 00:00:00';
                $to=$dates[1].' 23:59:59';
            }else{
                $from=$request->visibleRange.' 00:00:00';
                $to=$request->visibleRange.' 23:59:59';
            }
            //return $from;
        }else{
            $from=null;
            $to=null;
        }
        $formSheet=FormSheet::create([
            'ar'        =>[
                'name'      =>$request->ar['name'],
            ],
            'en'        =>[
                'name'      =>$request->en['name'],
            ],
            'visible'    =>$request->visible=='on',
            'user_type'  =>$request->user_type,
            'from'       =>$from,
            'to'         =>$to,
            //'admin_id'  =>auth()->guard('admin')->id()
        ]);
        $inputs=array_values($request->inputs);
        foreach ($inputs as $input)
            FormSheetInput::create([
                'ar'        =>[
                    'name'      =>$input['ar']['name'],
                ],
                'en'        =>[
                    'name'      =>$input['en']['name'],
                ],
                'form_sheet_id' =>$formSheet->id,
            ]);
        return redirect()->route('form-sheets.index')->with('success',__('frontend.itemCreated'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $form = FormSheet::with(['inputs'/*,'answers.inputAnswers','answers.user'*/])->findOrFail($id);
        return view('FormSheet.answers',compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  FormSheet  $formSheet
     * @return \Illuminate\Http\Response
     */
    public function edit(FormSheet  $formSheet)
    {
        return view('FormSheet.edit',compact('formSheet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  FormSheet  $formSheet
     * @return \Illuminate\Http\Response
     */
    public function update(FormSheetRequest $request, FormSheet  $formSheet)
    {
        if(isset($request->visibleRange)) {
            if(str_contains($request->visibleRange,' to ')){
                $dates = explode(" to ", $request->visibleRange);
                $from=$dates[0].' 00:00:00';
                $to=$dates[1].' 23:59:59';
            }else{
                $from=$request->visibleRange.' 00:00:00';
                $to=$request->visibleRange.' 23:59:59';
            }
            //return $from;
        }else{
            $from=null;
            $to=null;
        }
        $formSheet->update([
            'ar'        =>[
                'name'      =>$request->ar['name'],
            ],
            'en'        =>[
                'name'      =>$request->en['name'],
            ],
            'visible'    =>$request->visible=='on',
            'user_type'  =>$request->user_type,
            'from'       =>$from,
            'to'         =>$to,
        ]);
        if(isset($request->removed_inputs)&&count($request->removed_inputs)>0)
            FormSheetInput::whereIn('id',$request->removed_inputs)->where('form_sheet_id',$formSheet->id)->delete();
        //$ids=FormSheetInput::where('form_sheet_id',$formSheet->id)->pluck('id');
        foreach ($request->inputs as $input)
            FormSheetInput::create([
                'ar'        =>[
                    'name'      =>$input['ar']['name'],
                ],
                'en'        =>[
                    'name'      =>$input['en']['name'],
                ],
                'form_sheet_id' =>$formSheet->id,
            ]);
        return redirect()->route('form-sheets.index')->with('success',__('frontend.itemUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FormSheet  $formSheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormSheet  $formSheet)
    {
        $formSheet->delete();
        return $this->sendResponse([],__('frontend.itemDeleted'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAnswer($id)
    {
        $answer= FormSheetUserAnswer::findOrFail($id);
        $answer->delete();
        return $this->sendResponse([],__('frontend.itemDeleted'));
    }
}
