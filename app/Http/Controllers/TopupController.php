<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topup;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
    public function topUp(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated'
            ], 401);
        }

        $request->validate([
            'amount_topup' => 'required'
        ]);

        $balance = Auth::user()->balance;

        $data = new Topup();
        $data->amount_topup = $request->amount_topup;
        $data->balance_before = $balance;
        $data->balance_after = $balance + $request->amount_topup;
        $data->save();
    
        $user = Auth::user();
        $user->balance = $data->balance_after;
        $user->save();

        return response()->json([
            'status' => 'Sukses',
            'result' => $data,
        ]);
    }
}
