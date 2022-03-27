<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\DonationType;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type=\request()->type_id?DonationType::findOrFail(\request()->type_id):null;

        return view('Category.index',compact('type'));
    }
    public function dataTable()
    {
        if(\request()->type_id)
            $categories=Category::with('type')->withCount('options')->where('type_id',\request()->type_id)->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        else
            $categories=Category::with('type')->withCount('options')->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($categories,'get categories paginate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types=DonationType::get(['id']);
        return view('Category.create',compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category=Category::create([
            'ar'        =>[
                'name'      =>$request->ar['name'],
                'desc'      =>$request->ar['desc'],
            ],

            'en'        =>[
                'name'      =>$request->en['name'],
                'desc'      =>$request->en['desc'],
            ],

            'status'    =>$request->status,
            'type_id'   =>$request->type_id,
            'img'       =>'-',
            'admin_id'  =>auth()->guard('admin')->id()
        ]);
        $msg=__('frontend.uploadImageOf').$category->name;
        $input=['name'=>'category_id','value'=>$category->id];
        $files=['max'=>1,'mimes'=>".jpeg,.jpg,.png"];
        $uploadRoute=route('categories.uploadImg');
        $backRoute=route('categories.index');
        if($request->type_id)
        $backRoute.='?type_id='.$request->type_id;
        //return view('fileUpload',compact('input','files','msg','uploadRoute','backRoute'))->with('success',__('frontend.itemCreated'));

        return redirect(route('uploads.index',compact('input','files','msg','uploadRoute','backRoute')))->with('success',__('frontend.itemCreated'));
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
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category  $category)
    {
        $types = DonationType::get(['id']);
        return view('Category.edit',compact('category','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request,Category $category)
    {

        $category->update([
            'ar'        =>[
                'name'      =>$request->ar['name'],
                'desc'      =>$request->ar['desc'],
            ],
            'en'        =>[
                'name'      =>$request->en['name'],
                'desc'      =>$request->en['desc'],
            ],
            'status'    =>$request->status,
            'type_id'   =>$request->type_id,
            ///'img'       =>'images/categories/1648383890.jpg',
            'admin_id'  =>auth()->guard('admin')->id()
        ]);
        return redirect(route('categories.index'))->with('success',__('frontend.itemUpdated'));
    }
    public function uploadImg(Request $request){
        $request->validate([
            'file'          => 'required|mimes:png,jpg,jpeg,pdf|max:3072',
            'category_id'   => 'required|numeric',
        ]);
        $category=Category::findOrFail($request->category_id);
        $image = $request->file('file');

        $imageName = time().'.'.$image->extension();
        $filePath='images/categories';
        $image->move(public_path($filePath),$imageName);
        $category->update([
            'img'=>"$filePath/$imageName"
        ]);
        return response()->json(['success'=>$imageName]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category  $category)
    {
        $category->delete();
        return $this->sendResponse([],'category deleted success');
    }
}
