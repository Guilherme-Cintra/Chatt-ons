<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required',
        ]);
        $user = User::create(['name' => $request->name, 'email' => $request->email, 'password'=>Hash::make($request->password)]);

        return $user;
    }
}
