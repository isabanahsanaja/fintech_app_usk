<?php

namespace App\Http\Controllers;

use App\Models\Wallets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function topupNow(Request $request){
        $user_id = Auth::user()->id;
        $credit = $request->credit;
        $status = "proses";
        $description = "Top Up Saldo";

        Wallets::create([
            'user_id' => $user_id,
            'credit' => $credit,
            'status' => $status,
            'description' => $description,
        ]);

        return redirect()->back()->with('status','Berhasil merequest Topup. Silakan setor uang ke Teller Bank Mini');
    }

    public function acceptRequest(Request $request)
    {
        // $wallet_id = $request->wallet_id;
       $wallet =  Wallets::find($request->id);

       if($wallet){
          $wallet->update([
            'status'=> 'selesai',
          ]);
       }

        return redirect()->back()->with('status', 'Berhasil menyetujui request top up');
    }
}
