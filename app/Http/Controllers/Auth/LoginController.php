<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LoginController extends Controller
{
    public function login(Request $request){


        if(!Auth::attempt($request->only('phone_number','password'))){
            return response()->json([
                'status' => 'Phone Number and Password doesnt match'
            ],401);
        }

        $user = User::where('phone_number', $request->phone_number)->firstOrFail();

        // dd($user);

        $tokenResult = $user->createToken('auth_token');
        $token = $tokenResult->plainTextToken;

        return response()->json([
            'status' => 'Sukses',
            'access_token' => $token
        ],201);
    }
}
