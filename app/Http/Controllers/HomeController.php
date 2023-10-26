<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Products;
use App\Models\Transactions;
use App\Models\Wallets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->role == "bank"){
            $wallets = Wallets::where('status', 'selesai')->get();
            $credit = 0;
            $debit = 0;
    
            foreach($wallets as $wallet){
                $credit += $wallet->credit;
                $debit += $wallet->debit;
            }

            $saldo = $credit - $debit;
            $nasabah = User::where('role', 'siswa')->get()->count();
            $transactions = Transactions::all()->groupBy('order_id')->count();
            $request_topup = Wallets::where('status','proses')->get();

            return view('home', compact('saldo','nasabah','transactions','request_topup'));

        }

        if(Auth::user()->role == 'siswa'){
            $wallets = Wallets::where('user_id', Auth::user()->id)->where('status', 'selesai')->get();
            $credit = 0;
            $debit = 0;

            foreach($wallets as $wallet){
                $credit += $wallet->credit;
                $debit += $wallet->debit;
            }

            $saldo = $credit - $debit;
            $products = Products::all();
            $carts = Transactions::where('status', 'di keranjang')->get();

            $total_biaya = 0;

            foreach($carts as $cart) {
                $total_price = $cart->price * $cart->quantity;
                $total_biaya += $total_price;
            }

            $mutasi = Wallets::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
            $transactions = Transactions::where('status','dibayar')->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(5)->groupBy('order_id');
            
            return view('home', compact('saldo', 'products', 'carts', 'total_biaya', 'mutasi', 'transactions'));
        }

    }
}
