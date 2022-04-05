<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        return view('users.create');

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
        static::storeNewUser($request);
        return redirect(route('users.index'))->with('success',__('frontend.itemCreated'));
    }
    public static function storeNewUser($request){
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
            'status'        =>$request->get('status')?$request->get('status'):'pending',

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
        return view('users.edit',compact('user'));
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
}
