<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryOptionRequest;
use App\Models\Category;
use App\Models\CategoryOption;
use Illuminate\Http\Request;

class CategoryOptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category=Category::/*with('options')->*/findOrFail($request->category_id);
        return view('Category.Option.index',compact('category'));
    }

    public function dataTable()
    {
        //$parent_id=\request()->parent_id?\request()->parent_id:null;
        $options=CategoryOption::where('category_id',\request()->category_id)->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($options,'get category options paginate');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $category=Category::findOrFail($request->category_id);
        return view('Category.Option.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryOptionRequest $request)
    {
         CategoryOption::create([
            'ar'        =>[
                'name'      =>$request->ar['name'],
            ],
            'en'        =>[
                'name'      =>$request->en['name'],
            ],

            'category_id'       =>$request->category_id,
            'status'            =>$request->status,
            'type'              =>$request->type,
            'default_value'     =>$request->default_value,
            'accept_any_value'  =>$request->accept_any_value=='on'?true:false,
            'admin_id'          =>auth()->guard('admin')->id()
        ]);
        return redirect(route('category-option.index',['category_id'=>$request->category_id]))->with('success',__('frontend.itemCreated'));

    }

    /**
     * Display the specified resource.
     *
     * @param  CategoryOption  $categoryOption
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryOption $categoryOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CategoryOption  $categoryOption
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryOption $categoryOption)
    {
        return view('Category.Option.edit',compact('categoryOption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  CategoryOption  $categoryOption
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryOptionRequest $request, CategoryOption $categoryOption)
    {
        //return $request;
        $categoryOption->update([
            'ar'        =>[
                'name'      =>$request->ar['name'],
            ],
            'en'        =>[
                'name'      =>$request->en['name'],
            ],

            'category_id'       =>$request->category_id,
            'status'            =>$request->status,
            'type'              =>$request->type,
            'default_value'     =>$request->default_value,
            'accept_any_value'  =>$request->accept_any_value=='on'?true:false,
            'admin_id'          =>auth()->guard('admin')->id()
        ]);
        return redirect(route('category-option.index',['category_id'=>$request->category_id]))->with('success',__('frontend.itemUpdated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CategoryOption $categoryOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryOption $categoryOption)
    {
        $categoryOption->delete();
        return $this->sendResponse([],'category option deleted success');

    }
}
