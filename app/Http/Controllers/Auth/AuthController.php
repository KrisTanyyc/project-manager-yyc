<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController 
{
    //
    public function create(){

        return inertia('Auth/Login');    
    }

    public function store(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->input('remember');

        

        if(Auth::attempt(['email' => $email, 'password' => $password], $remember))
        {
            $user = Auth::user();
            $roles = $user->roles()->pluck('role_id')->toArray();

            if (in_array(1, $roles)){
               

                return response()->json([
                    'success' => 'Login Successful'
                ]);
            } 
        
        }
        else{
            return response()->json([
                'error' => 'These credentials do not match our records.'
            ]);

        }
        
    }

    public function destroy(){
        Auth::logout();


        return response()->json([
            'success' => 'logout success!'
        ]);
    }

}

