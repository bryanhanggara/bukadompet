<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(UserRequest $request){

        $user = $request->all();
        
        $data = User::create($user);
    
        return response()->json([
            'status' => 'Sukses',
            'data' => $data
        ], 200);
    }
}
