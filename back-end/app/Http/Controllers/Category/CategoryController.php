<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
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
        $parent=\request()->parent_id?Category::findOrFail(\request()->parent_id):null;

        return view('Category.index',compact('parent'));
    }
    public function dataTable()
    {
        $parent_id=\request()->parent_id?\request()->parent_id:null;
        $categories=Category::with('parent')->withCount('childes')->where('parent_id',$parent_id)->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($categories,'get categories paginate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::get(['id']);
        return view('Category.create',compact('categories'));
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
            'parent_id' =>$request->parent_id,
            'img'       =>'$request->parent_id',
            'admin_id'  =>auth()->guard('admin')->id()
        ]);
        $msg=__('frontend.uploadImageOf').$category->name;
        $input=['name'=>'category_id','value'=>$category->id];
        $files=['max'=>1,'mimes'=>".jpeg,.jpg,.png"];
        $uploadRoute=route('categories.uploadImg');
        $backRoute=route('categories.index');
        if($request->parent_id)
        $backRoute.='?parent_id='.$request->parent_id;
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
        $categories=Category::get(['id']);

        return view('Category.edit',compact('category','categories'));
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
            'parent_id' =>$request->parent_id,
            'img'       =>'$request->parent_id',
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
