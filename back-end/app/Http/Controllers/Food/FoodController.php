<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use App\Http\Requests\Food\CreateUpdateFoodRequest;
use App\Models\Food;
use App\Models\FoodTranslation;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\Facades\FastExcel;
class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('Food.index');
    }
    public function dataTable(){
        $options=Food::/*with(['category','user','option','donationType'])->*/customFilter(\request()->filters)->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($options,'get foods paginate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Food.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateFoodRequest $request)
    {

        $food=Food::create([
            'ar'        =>[
                'name'      =>$request->ar['name'],
                'desc'      =>$request->ar['desc'],
            ],
            'en'        =>[
                'name'      =>$request->en['name'],
                'desc'      =>$request->en['desc'],
            ],
            'type'          =>$request->type,
            'available'     =>$request->available=='on',
            'price'         =>$request->price,
            'img'           =>$request->img,
            'admin_id'      =>auth('admin')->user()->id,
        ]);
        $msg=__('frontend.uploadImageOf').$food->name;
        $input=['name'=>'food_id','value'=>$food->id,'model'=>Food::class];
        $files=['max'=>1,'mimes'=>".jpeg,.jpg,.png"];
        $uploadRoute=route('foods.uploadImg');
        $backRoute=route('foods.index');
        if($request->type_id)
            $backRoute.='?type_id='.$request->type_id;
        //return view('fileUpload',compact('input','files','msg','uploadRoute','backRoute'))->with('success',__('frontend.itemCreated'));

        return redirect(route('uploads.index',compact('input','files','msg','uploadRoute','backRoute')))->with('success',__('frontend.itemCreated'));
    }
    public function uploadImg(Request $request){
        $request->validate([
            'file'          => 'required|mimes:png,jpg,jpeg,pdf|max:3072',
            'food_id'       => 'required|numeric',
        ]);
        $food=Food::findOrFail($request->food_id);
        $image = $request->file('file');

        $imageName = time().'.'.$image->extension();
        $filePath='images/foods';
        $image->move(public_path($filePath),$imageName);
        $food->update([
            'img'=>"$filePath/$imageName"
        ]);
        return response()->json(['success'=>$imageName]);
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
     * @param  Food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Food  $food)
    {
        return view('Food.edit',compact('food'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUpdateFoodRequest $request, Food  $food)
    {
        $food->update([
            'ar'        =>[
                'name'      =>$request->ar['name'],
                'desc'      =>$request->ar['desc'],
            ],
            'en'        =>[
                'name'      =>$request->en['name'],
                'desc'      =>$request->en['desc'],
            ],            'type'          =>$request->type,
            'available'     =>$request->available=='on',
            'price'         =>$request->price,
            //'img'           =>$request->img,
            'admin_id'      =>auth('admin')->user()->id,
        ]);
        return redirect(route('foods.index'))->with('success',__('frontend.itemUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food  $food)
    {
        $food->delete();
        return $this->sendResponse([],__('frontend.itemDeleted'));

    }

    public function export(){
        $foods = Food::all();
        $foods->each->setTranslated(['ar','en']);
     //   return \fastexcel(Food::all())->download('foods.xlsx');
        return \fastexcel($foods)->download('foods.xlsx',function ($line) {
            return [
                'name_ar' => $line['name_ar'],
                'desc_ar' => $line['desc_ar'],
                'name_en' => $line['name_en'],
                'desc_en' => $line['desc_en'],
                'type' => $line['type'],
                'available' => $line['available'],
                'price' => $line['price'],
            ];
        });
        //return (new FastExcel($foods))->export('foods.xlsx');
    }
    public function importPage(){
        $msg=__('frontend.importData').__('frontend.foods');
        $input=['name'=>'foods','value'=>'','model'=>Food::class];
        $files=['max'=>1,'mimes'=>".xlsx,.csv"];
        $uploadRoute=route('foods.import');
        $backRoute=route('foods.index');
        return redirect(route('uploads.index',compact('input','files','msg','uploadRoute','backRoute')));
        //->with('success',__('frontend.itemCreated'));
    }
    public function importData(Request $request){
        $request->validate([
            'file'          => 'required|mimes:csv,xlsx',
        ]);
        $file = storage_path('app/' . $request->file('file')->store('excel-files\foods'));
        //return \fastexcel()->import($file);
        return FastExcel::import($file, function ($line) {
            //dd($line);
            return Food::create([
                'ar'        =>[
                    'name'      =>$line['name_ar'],
                    'desc'      =>$line['desc_ar'],
                ],
                'en'        =>[
                    'name'      =>$line['name_en'],
                    'desc'      =>$line['desc_en'],
                ],
                'type'          =>$line['type'],
                'available'     =>$line['available'],
                'price'         =>$line['price'],
                'admin_id'      =>auth('admin')->user()->id,
            ]);
        });
    }

}
