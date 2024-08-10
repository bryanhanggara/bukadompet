<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Topup;
use App\Models\Payment;
use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
   public function getTransactionHistory()
   {
    $user = Auth::user();

    $topups = Topup::where('user_id', $user->id)
                 ->select('user_id','amount_topup as amount', 'balance_before', 'balance_after', 'created_at', 'updated_at')
                 ->addSelect(\DB::raw("'Top-up' as type"))
                 ->get();

    $payments = Payment::where('user_id', $user->id)
                ->select('user_id','amount', 'balance_before', 'balance_after', 'created_at', 'updated_at')
                ->addSelect(\DB::raw("'Payment' as type"))
                ->get();
    
    $transfers = Transfer::where('user_id', $user->id)
                ->select('user_id','amount', 'balance_before', 'balance_after', 'created_at', 'updated_at')
                ->addSelect(\DB::raw("'Transfer' as type"))
                ->get();

    $transactions = $topups->merge($transfers)->merge($payments);

    $transactions = $transactions->sortByDesc('created_at');

    return response()->json([
        'status' => 'Sukses',
        'transactions' => $transactions,
    ], 200);
   }
}
