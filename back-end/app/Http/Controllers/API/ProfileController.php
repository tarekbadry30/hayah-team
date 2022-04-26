<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function user(Request $request){
        return $request->user();
    }

    public function update(Request $request){
       // return $request->header();
        $data=$request->toArray();
        $defaultRules=[
            'name'              =>  'required|string|min:3',
            'password'          =>  'required|string|min:6',
            'phone'             =>  'required|string|unique:users,phone,' . $request->user()->id,
            'address'           =>  'required',
            'lat'               =>  'required',
            'long'              =>  'required',
            'national_number'   =>  'required|string|unique:users,national_number,'.$request->user()->id,
        ];

        $rules=[];
        foreach ($data as $index=>$item){
            if(isset($defaultRules[$index]))
                $rules[$index]=$defaultRules[$index];
                //$data[$index]=$defaultRules[$index];
        }
        $request->validate($rules);
        //return $rules;
        if(isset($data['password'])){
            $rules['password']='required|string|min:6';
            $data['password']=Hash::make($request->password);
        }
        //return $data;
        $request->user()->update($data);
        return $this->sendResponse([],'user profile updated');
    }
}
