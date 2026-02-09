<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login(Request $request){

    $tenant = app('tenant');

    $credentials = $request->only('email','password');

    if (!Auth::attempt($credentials)) {
        return response()->json(['error'=>'Invalid credentials'], 401);
    }

    $user = Auth::user();

    if ($user->tenant_id !== $tenant->id) {
        return response()->json(['error'=>'Wrong tenant'], 403);
    }

    $token = $user->createToken('api')->plainTextToken;

    return response()->json(['token'=>$token]);
    }

}