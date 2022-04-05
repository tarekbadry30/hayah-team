<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use App\Http\Requests\Food\CreateUpdateFoodRequest;
use App\Models\Food;
use Illuminate\Http\Request;

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
}
