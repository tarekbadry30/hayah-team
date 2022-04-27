<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Users.index');
    }
    public function dataTable()
    {
        $users=User::with('lastHelp')->paginate(\request()->has('itemsPerPage')?\request()->itemsPerPage:25);
        return $this->sendResponse($users,'get users paginate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Users.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        //return $request;
        $status=$request->status?$request->status:'pending';
        static::storeNewUser($request,$status);
        return redirect(route('users.index'))->with('success',__('frontend.itemCreated'));
    }
    public static function storeNewUser($request,$status='pending'){
       /* if(!isset($request->status))
            $request->status='pending';
        echo json_encode($request);
        die();*/
        return User::create([
            'name'          =>$request->name,
            'phone'         =>$request->phone,
            'address'       =>$request->address,
            'national_number'=>$request->national_number,
            'type'          =>$request->get('type'),
            'status'        =>$status,

            'password'      =>Hash::make($request->password),
        ]);
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
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('Users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request, User $user)
    {
        $user->update([
            'name'          =>$request->name,
            'phone'         =>$request->phone,
            'address'       =>$request->address,
            'national_number'=>$request->national_number,
            'type'          =>$request->get('type'),
            'status'        =>$request->get('status'),
            'password'      =>$request->password?Hash::make($request->password):$user->password,
        ]);
        return redirect(route('users.index'))->with('success',__('frontend.itemUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->sendResponse([],'user deleted success');

    }


    public function export(){
        $list = User::all();
        //$categories->each->setTranslated(['ar','en']);
        return \fastexcel($list)->download('users.xlsx',function ($line) {
            //dd($line);
            return [
                'name'      => $line['name'],
                'phone'     => $line['phone'],
                'address'   => $line['address'],
                'national_number'=> $line['national_number'],
                'type'      => $line['type'],
                'status'    => $line['status'],
            ];

        });
        //return (new FastExcel($foods))->export('foods.xlsx');
    }
    public function importPage(Request $request){
        $msg=__('frontend.importData').__('frontend.users');
        $input=['name'=>'user_id','value'=>'user_id','model'=>User::class];
        $files=['max'=>1,'mimes'=>".xlsx,.csv"];
        $uploadRoute=route('users.import');
        $backRoute=route('users.index');
        return redirect(route('uploads.index',compact('input','files','msg','uploadRoute','backRoute')));
        //->with('success',__('frontend.itemCreated'));
    }
    public function importData(Request $request){
        $request->validate([
            'file'          => 'required|mimes:csv,xlsx',
        ]);
        $file = storage_path('app/' . $request->file('file')->store('excel-files\users'));

        //return \fastexcel()->import($file);
        return FastExcel::import($file, function ($line) use ($request) {
            $ducblicated= User::where('phone',$line['phone'])->orWhere('national_number',$line['national_number'])->first();
            if($ducblicated){
                $row='[';
                if($ducblicated->phone==$line['phone'])
                    $row.='phone='.$line['phone'].'  ,';
                if($ducblicated->national_number==$line['national_number'])
                    $row.='national_number='.$line['national_number'].'  ,';
                $row.=']';
                return $this->sendError('duplicated data with row'.$row,400);
            }

            return User::create([
                'name'      => $line['name'],
                'phone'     => $line['phone'],
                'address'   => $line['address'],
                'national_number'=> $line['national_number'],
                'type'      => $line['type'],
                'status'    => $line['status'],
                'password'  => Hash::make($line['password']),
                //'admin_id'  =>auth('admin')->id(),
            ]);
        });
    }

}
