<?php

namespace App\Http\Controllers\Donations;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationTypeRequest;
use App\Models\DonationType;
use App\Models\DonationTypeTranslation;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

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
       $donation=DonationType::create([
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
        $msg=__('frontend.uploadImageOf').$donation->name;
        $input=['name'=>'donation_type_id','value'=>$donation->id];
        $files=['max'=>1,'mimes'=>".jpeg,.jpg,.png"];
        $uploadRoute=route('donation-types.uploadImg');
        $backRoute=route('donation-types.index');
        //return view('fileUpload',compact('input','files','msg','uploadRoute','backRoute'))->with('success',__('frontend.itemCreated'));

        return redirect(route('uploads.index',compact('input','files','msg','uploadRoute','backRoute')))->with('success',__('frontend.itemCreated'));

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
        return redirect(route('donation-types.index'))->with('success',__('frontend.itemDeleted'));

    }

    public function uploadImg(Request $request){
        $request->validate([
            'file'            => 'required|mimes:png,jpg,jpeg,pdf|max:3072',
            'donation_type_id'=> 'required|numeric',
        ]);
        $food=DonationType::findOrFail($request->donation_type_id);
        $image = $request->file('file');

        $imageName = time().'.'.$image->extension();
        $filePath='images/donations-types';
        $image->move(public_path($filePath),$imageName);
        $food->update([
            'img'=>"$filePath/$imageName"
        ]);
        return response()->json(['success'=>$imageName]);
    }

    public function export(){
        $list = DonationType::all();
        $list->each->setTranslated(['ar','en']);
        return \fastexcel($list)->download('donation_types.xlsx',function ($line) {
            //dd($line);
            return [
                'name_ar'      =>$line['name_ar'],
                'desc_ar'      =>$line['desc_ar'],
                'name_en'      =>$line['name_en'],
                'desc_en'      =>$line['desc_en'],
                'status'        =>$line['status'],
            ];

        });
        //return (new FastExcel($foods))->export('foods.xlsx');
    }
    public function importPage(Request $request){
        $msg=__('frontend.importData').__('frontend.donationTypes');
        $input=['name'=>'donation_id','value'=>'donation_id','model'=>DonationType::class];
        $files=['max'=>1,'mimes'=>".xlsx,.csv"];
        $uploadRoute=route('donation-types.importData');
        $backRoute=route('donation-types.index');
        return redirect(route('uploads.index',compact('input','files','msg','uploadRoute','backRoute')));
        //->with('success',__('frontend.itemCreated'));
    }
    public function importData(Request $request){
        $request->validate([
            'file'          => 'required|mimes:csv,xlsx',
        ]);
        $file = storage_path('app/' . $request->file('file')->store('excel-files/donation-types'));

        //return \fastexcel()->import($file);
        return FastExcel::import($file, function ($line) use ($request) {
            $ducblicated= DonationTypeTranslation::where([
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

            return DonationType::create([
                'ar'        =>[
                    'name'      =>$line['name_ar'],
                    'desc'      =>$line['desc_ar'],
                ],
                'en'        =>[
                    'name'      =>$line['name_en'],
                    'desc'      =>$line['desc_en'],
                ],
                'status'    =>$line['status'],
                'admin_id'  =>auth()->guard('admin')->id()
            ]);
        });
    }

}
