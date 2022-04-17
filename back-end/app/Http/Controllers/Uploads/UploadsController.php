<?php

namespace App\Http\Controllers\Uploads;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DonationHelp;
use App\Models\DonationType;
use App\Models\Food;
use App\Models\MobileSlider;
use App\Models\Slider;
use App\Models\WebsiteSlider;
use Illuminate\Http\Request;

class UploadsController extends Controller
{
    public function index(Request $request){
        if(isset($request->model)) {
            $params=[
            'msg'=>'',
                //__('frontend.uploadImageOf').$category->name;
            'input'=>[
                'name'=>'',
                'value'=>1
            ],
            'files'=>[
                'max'=>1,
                'mimes'=>""
            ],
            'uploadRoute'=>'#',
            'backRoute'=>url()->previous(),
        ];
                //['name'=>'category_id','value'=>$category->id];
            //$files=['max'=>1,'mimes'=>".jpeg,.jpg,.png"];
            //$uploadRoute=route('categories.uploadImg');
            $backRoute=route('categories.index');
            switch ($request->model) {
                case 'Category':
                    $params=Category::find($request->value)->uploadParams();
                    break;
                case 'Food':
                    $params=Food::find($request->value)->uploadParams();
                    break;
                case 'DonationHelp':
                    $params=DonationHelp::find($request->value)->uploadParams();
                    break;
                case 'DonationType':
                    $params=DonationType::find($request->value)->uploadParams();
                    break;
                case 'WebsiteSlider':
                    if($request->value)
                    $params=WebsiteSlider::find($request->value)->uploadParams();
                    else
                        $params=(new WebsiteSlider())->uploadParams();
                    break;
                case 'MobileSlider':
                    if($request->value)
                    $params=MobileSlider::find($request->value)->uploadParams();
                    else
                        $params=(new MobileSlider())->uploadParams();
                    break;
            }
            return view('fileUpload', $params);//->with('success',__('frontend.itemCreated'));
            }
        return view('fileUpload',$request->toArray());//->with('success',__('frontend.itemCreated'));

    }
}
