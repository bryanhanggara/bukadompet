<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Transfer;

class TransferController extends Controller
{
    public function transfer(Request $request)
    {
        $request->validate([
            'user_receive_amount' => 'required|uuid|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'remaks' => 'nullable|string'
        ]);
    
        $user = Auth::user();

        if ($user->balance < $request->amount) {
            return response()->json([
                'status' => 'error',
                'message' => 'Balance is Not Enough'
            ], 400);
        }

        $receiver = User::findOrFail($request->user_receive_amount);
    
        $transfer = new Transfer();
        $transfer->user_receive_amount = $receiver->id;
        $transfer->amount = $request->amount;
        $transfer->remaks = $request->remaks;
        $transfer->balance_before = $user->balance;
        $transfer->balance_after = $user->balance - $request->amount;
        $transfer->save();

        $user->balance -= $request->amount;
        $user->save();

        $receiver->balance += $request->amount;
        $receiver->save();

        return response()->json([
            'status' => 'Sukses',
            'transfer' => $transfer,
        ], 201);
    }
}
