<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    function login(Request $request)  {

        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
          
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
          return response()->json(['message'=>'login success','data'=>new UserResource(Auth::user())],200);
        }
        return response()->json(['message'=>'login failed'],203);
    }

    function register(Request $request)  {

       $request = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

       DB::transaction(function()use($request){
        $user = User::create($request);
        Auth::login($user);
       });
       
       return response()->json(['message'=>'register success','data'=>new UserResource(Auth::user())],201);
    }
}
