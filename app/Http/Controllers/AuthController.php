<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //
    public function login(Request $request){
        // return view('auth.login');
        //validation input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        //error validator
        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'message' => 'validation error',
                'data' => $validator->errors()
            ], 422);
        }
        // //user login
        // $user =Auth::user();
        // //create token
        // $token = $user->createToken('auth_token')->plainTextToken;
        $credentials =$request->only('email', 'password');
        if(Auth::attempt($credentials)){
            $token=auth()->user()->createToken('auth_token')->plainTextToken;
            return response([
                'status' => 'success',
                'message' => 'user logged in successfully',
                'token' => $token,
            ],200);

        }else {
            
            return response([
                'status' => 'error',
                'message' => 'Unauthorized',

            ],401);
        }
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 'error',
                'message' => 'validation error',
                'data' => $validator->errors()
            ], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'status' => 'success',
            'message' => 'user created successfully',
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }
    public function logout(){
        Auth::user()->tokens()->delete();//នៅពេលដែលយើង logout វានិងធ្វើការ delete tokens ចេះ
        return response([
            'status' => 'success',
            'message' => 'user logged out successfully',
        ],200);
    }


}
