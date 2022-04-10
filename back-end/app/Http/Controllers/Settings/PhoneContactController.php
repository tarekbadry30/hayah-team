<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\PhonesRequest;
use App\Models\Settings\ContactPhone;
use App\Models\Settings\ContactPhoneTranslation;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class PhoneContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phones=ContactPhone::get();
        return view('Settings.phone.index',compact('phones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Settings.phone.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhonesRequest $request)
    {
        ContactPhone::create([
            'ar'=>[
                'name'      =>$request->ar['name'],
            ],
            'en'=>[
                'name'      =>$request->en['name'],
            ],
            'phone' =>$request->phone,
        ]);
        return redirect()->route('settings.phone.index')->with('success',__('frontend.itemCreated'));
    }

    /**
     * Display the specified resource.
     *
     * @param  ContactPhone  $phone
     * @return \Illuminate\Http\Response
     */
    public function show(ContactPhone  $phone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param   ContactPhone  $phone
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactPhone  $phone)
    {
        return view('Settings.phone.edit',compact('phone'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ContactPhone  $phone
     * @return \Illuminate\Http\Response
     */
    public function update(PhonesRequest $request, ContactPhone  $phone)
    {
        $phone->update([
            'ar'=>[
                'name'      =>$request->ar['name'],
            ],
            'en'=>[
                'name'      =>$request->en['name'],
            ],
            'phone' =>$request->phone,
        ]);
        return redirect()->route('settings.phone.index')->with('success',__('frontend.itemUpdated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ContactPhone  $phone
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactPhone  $phone)
    {
        $phone->delete();
        return $this->sendResponse([],__('frontend.itemDeleted'));
    }

    public function export(){
       $list=ContactPhone::all();
        $list->each->setTranslated(['ar','en']);
        return \fastexcel($list)->download('contact_phones.xlsx',function ($line) {
            //dd($line);
            return [
                'name_ar' => $line['name_ar'],
                'name_en' => $line['name_en'],
                'phone'   =>$line['phone'],
            ];
        });
        //return (new FastExcel($foods))->export('foods.xlsx');
    }
    public function importPage(){
        $msg=__('frontend.importData').__('frontend.contactPhone');
        $input=['name'=>'phone_id','value'=>'phone_id','model'=>ContactPhone::class];
        $files=['max'=>1,'mimes'=>".xlsx,.csv"];
        $uploadRoute=route('settings.phone.import');
        $backRoute=route('settings.phone.index');
        return redirect(route('uploads.index',compact('input','files','msg','uploadRoute','backRoute')));
        //->with('success',__('frontend.itemCreated'));
    }
    public function importData(Request $request){
        $request->validate([
            'file'          => 'required|mimes:csv,xlsx',
        ]);
        $file = storage_path('app/' . $request->file('file')->store('excel-files\phones'));
        //return \fastexcel()->import($file);
        return FastExcel::import($file, function ($line) use ($request) {
            $ducblicated= ContactPhoneTranslation::where([
                ['name',$line['name_ar']],
                ['locale','ar'],
            ])->orWhere([
                ['name',$line['name_en']],
                ['locale','en'],
            ])->first();
            if($ducblicated){
                $row='[';
                if($ducblicated->name==$line['name_en'])
                    $row.='name_en='.$line['name_en'].'  ,';
                if($ducblicated->name==$line['name_ar'])
                    $row.='name_ar='.$line['name_ar'].'  ,';
                $row.=']';
                return $this->sendError('duplicated data with row'.$row,400);
            }
            $ducblicated= ContactPhone::where('phone',$line['phone'])->first();
            if($ducblicated){
                $row='[phone='.$line['phone'].']';
                return $this->sendError('duplicated data with row'.$row,400);
            }
            return ContactPhone::create([
                'ar'        =>[
                    'name'      =>$line['name_ar'],
                ],
                'en'        =>[
                    'name'      =>$line['name_en'],
                ],
                //'type'          =>$line['type'],
                'phone'         =>$line['phone'],

            ]);
        });
    }
}
