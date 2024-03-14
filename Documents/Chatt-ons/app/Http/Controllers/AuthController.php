<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use League\Config\Exception\ValidationException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request){

        try{
            $request->validate([
                'name'=>'required',
                'email'=>'required|unique:users',
                'password'=>'required',
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password'=>Hash::make($request->password)]);
            return response()->json([
                'message'=> 'registration successfull',
                'user'=> $user
            ], 201);
            
    
        } catch(Exception $e){
            Log::error($e);
            return response()->json([
                'error'=>$e->getMessage()
            ],400);
        }
         catch(ValidationException $e){
            Log::error($e);
            return response()->json([
                'error'=> 'Validation error',
                'message' => $e->getMessage()
            ],400);
        }
       
    }


    public function login(Request $request){
        try{
            $request->validate([
                'email'=>'required',
                'password'=>'required',
            ]);
        }  catch(Exception $e){
            Log::error($e);
            return response()->json([
                'error'=>$e->getMessage()
            ],400);
        }
        
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'error'=> 'The provided credentials are incorrect.'
            ], 404);
        }

        return response()->json([
            'message'=>'login succesfull',
            'user'=> $user,
            'token'=> $user->createToken('my_token')->plainTextToken
        ], 200);
        
      
    }
}
