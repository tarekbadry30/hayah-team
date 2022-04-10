<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\DonationType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

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
        //$types=DonationType::all();
        $types=  DB::table('donation_types')
            ->select('donation_types.id','donation_type_translations.name','donation_type_translations.locale')
            ->join('donation_type_translations','donation_type_translations.donation_type_id','=','donation_types.id')
            ->where(['donation_type_translations.locale' => LaravelLocalization::getCurrentLocale()])
            ->get();
        return view('Category.index',compact('type','types'));
    }
    public function dataTable()
    {

            $categories=Category::with('type')->CustomFilter(\request()->filters)->withCount('options')->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($categories,'get categories paginate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types=  DB::table('donation_types')
            ->select('donation_types.id','donation_type_translations.name','donation_type_translations.locale')
            ->join('donation_type_translations','donation_type_translations.donation_type_id','=','donation_types.id')
            ->where(['donation_type_translations.locale' => LaravelLocalization::getCurrentLocale()])
            ->get();
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
            'urgent'    =>$request->urgent=='on',
            'needed_value'=>$request->needed_value,
            'collected_value'=>0,
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
        $types=  DB::table('donation_types')
            ->select('donation_types.id','donation_type_translations.name','donation_type_translations.locale')
            ->join('donation_type_translations','donation_type_translations.donation_type_id','=','donation_types.id')
            ->where(['donation_type_translations.locale' => LaravelLocalization::getCurrentLocale()])
            ->get();
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
            'urgent'    =>$request->urgent=='on',
            'needed_value'=>$request->needed_value,
            //'collected_value'=>0,
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



    public function export(Request $request){
        if(isset($request->type_id))
            $categories = Category::where('type_id',$request->type_id)->get();
        else
            $categories = Category::all();
        $categories->each->setTranslated(['ar','en']);
        return \fastexcel($categories)->download('categories.xlsx',function ($line) {
            //dd($line);
            return [
                'name_ar' => $line['name_ar'],
                'name_en' => $line['name_en'],
                'desc_ar' => $line['desc_ar'],
                'desc_en' => $line['desc_en'],
                'status'  => $line['status'],
                'urgent'        =>$line['urgent'],
                'needed_value'  =>$line['needed_value'],
                'collected_value'=>$line['collected_value'],
            ];
        });
        //return (new FastExcel($foods))->export('foods.xlsx');
    }
    public function importPage(Request $request){
        $msg=__('frontend.importData').__('frontend.categories');
        $input=['name'=>'type_id','value'=>$request->type_id,'model'=>Category::class];
        $files=['max'=>1,'mimes'=>".xlsx,.csv"];
        $uploadRoute=route('categories.import');
        $backRoute=route('categories.index');
        return redirect(route('uploads.index',compact('input','files','msg','uploadRoute','backRoute')));
        //->with('success',__('frontend.itemCreated'));
    }
    public function importData(Request $request){
        $request->validate([
            'file'          => 'required|mimes:csv,xlsx',
            'type_id'       => 'required',
        ]);
        $file = storage_path('app/' . $request->file('file')->store('excel-files\categories'));
        //return \fastexcel()->import($file);
        return FastExcel::import($file, function ($line) use ($request) {
            //dd($line);
            return Category::create([
                'ar'        =>[
                    'name'      =>$line['name_ar'],
                    'desc'      =>$line['desc_ar'],
                ],
                'en'        =>[
                    'name'      =>$line['name_en'],
                    'desc'      =>$line['desc_en'],
                ],
                //'type'          =>$line['type'],
                'status'        =>$line['status'],
                'urgent'        =>$line['urgent'],
                'needed_value'  =>$line['needed_value'],
                'collected_value'=>0,
                'type_id'       =>$request->type_id,
                'admin_id'      =>auth('admin')->id(),
            ]);
        });
    }
}
