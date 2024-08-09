<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated'
            ], 401);
        }

        $request->validate([
            'amount' => 'required',
            'remaks' => 'required'
        ]);

        $balance = Auth::user()->balance;

        $data = new Payment();
        $data->amount = $request->amount;
        $data->remaks = $request->remaks;
        $data->balance_before = $balance;
        
        if($balance < $request->amount){
            return response()->json([
                'message' => 'balance not enough'
            ]);
        }

        $data->balance_after = $balance - $request->amount;

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
