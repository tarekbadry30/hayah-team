<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use App\Http\Requests\Food\CreateMonthlyHelp;
use App\Models\User;
use App\Models\UserMonthHelp;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonthlyHelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user=User::/*with('monthlyHelp')->*/findOrFail($request->user_id);
        return view('Month.index',compact('user'));

    }
    public function dataTable(Request $request)
    {
        $helps=UserMonthHelp::customFilter(\request()->filters)->orderBy('month','desc')->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($helps,'get helps paginate');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user=User::findOrFail($request->user_id);
        if($user->type!='needy')
            return back();
        return view('Month.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMonthlyHelp $request)
    {
        $month=Carbon::parse('01-'.$request->month)->format('Y-m-d H:i:s');
        $exist=UserMonthHelp::where([
            ['user_id',$request->user_id],
            ['month',$month],
        ])->first();
        if($exist)
            return redirect()->back()->withErrors(['month'=>__('frontend.hasGetHelpMonth').$request->month]);
        $monthlyHelp=UserMonthHelp::create([
            'user_id'           =>$request->user_id,
            'month'             =>Carbon::parse('01-'.$request->month)->format('Y-m-d H:i:s'),
            'help_value'        =>$request->help_value,
            'total_value'       =>$request->help_value,
            'remaining_value'   =>$request->help_value,
            'admin_id'          =>auth('admin')->user()->id,
        ]);
        return redirect(route('monthly-help.index',['user_id'=>$request->user_id]))->with('success',__('frontend.itemCreated'));

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
     * @param   UserMonthHelp  $monthlyHelp
     * @return \Illuminate\Http\Response
     */
    public function edit( UserMonthHelp  $monthlyHelp)
    {
        //return \request();
        return view('Month.edit',['help'=>$monthlyHelp]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  UserMonthHelp  $monthlyHelp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,UserMonthHelp $monthlyHelp)
    {
        $data=[
            'help_value'        =>$monthlyHelp->help_value,
            'remaining_value'   =>$monthlyHelp->remaining_value,
        ];
        if($request->help_value!=$monthlyHelp->help_value){
            $data['help_value']=$request->help_value;
            $data['remaining_value']=($request->help_value-$monthlyHelp->remaining_value);//+$monthlyHelp->remaining_value;
        }
        $monthlyHelp->update($data);
        return redirect(route('monthly-help.index',['user_id'=>$monthlyHelp->user_id]))->with('success',__('frontend.itemUpdated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserMonthHelp $monthlyHelp
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserMonthHelp $monthlyHelp)
    {
        $monthlyHelp->delete();
        return $this->sendResponse([],'monthly help deleted success');

    }
}
