<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Users\UsersController;
use App\Http\Requests\Auth\APILogin;
use App\Http\Requests\UsersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
    public function usersLogin(Request $request){
        $request->validate([
            'phone'     => 'required|string',
            'password'  => 'required|string'
        ]);
        if(Auth::attempt(['phone' => $request->phone, 'password' => $request->password])){
            $user = Auth::user();
            if($user->status!='active')
                return $this->sendError('account '.$user->status, ['error'=>'your account status "'.$user->status.'"']);

            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['user'] =  $user;
            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('يوجد خطأ برقم الجوال او كلمة المرور.',
            ['error'=>'login failed']);
        }
    }
    public function driversLogin(Request $request){
        $request->validate([
            'phone'     => 'required|string',
            'password'  => 'required|string'
        ]);
        //return json_encode(config('auth.guards'));
        if(Auth::guard('delivery')->attempt(['phone' => $request->phone, 'password' => $request->password])){
            $user = Auth::guard('delivery')->user();
            if($user->status!='active')
                return $this->sendError('account '.$user->status, ['error'=>'your account status "'.$user->status.'"']);

            $success['token'] =  $user->createToken('delivery')->plainTextToken;
            $success['user'] =  $user;
            return $this->sendResponse($success, 'delivery login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'login failed']);
        }
    }
    public function usersRegister(UsersRequest $request){
        if($request->get('type')=='benefactor')
            $status='active';
        else
            $status='pending';
        //return $status;

        $user=UsersController::storeNewUser($request,$status);
        $success['user'] =  $user;
        return $this->sendResponse($success, 'User Created successfully.');
    }
}
