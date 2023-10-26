<?php

namespace App\Http\Controllers;


use App\Models\Transactions;
use App\Models\Wallets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function addToCart(Request $request)
    {
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $status = 'di keranjang';
        $price = $request->price;
        $quantity = $request->quantity;

        Transactions::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'status' => $status,
            'price' => $price,
            'quantity' => $quantity,
        ]);

        return redirect()->back()->with('status', 'Berhasil Menambah Ke Keranjang');
    }

    public function payNow()
    {
        $status = 'dibayar';
        $order_id = 'INV_' . Auth::user()->id . date('YmdHis');
        
        $carts = Transactions::where('user_id', Auth::user()->id)->where('status', 'di keranjang')->get();

        $total_debit = 0;

        foreach($carts as $cart) {
            $total_price = $cart->price * $cart->quantity;

            $total_debit += $total_price; 
        }

        Wallets::create([
            'user_id' => Auth::user()->id,
            'debit' => $total_debit,
            'description' => 'Pembelian Produk'
        ]);

        foreach($carts as $cart) {
            Transactions::find($cart->id)->update([
                'status' => $status,
                'order_id' => $order_id
            ]);
        }

        return redirect()->back()->with('status', 'Berhasil membayar transaksi');
    }

    public function download($order_id){
        $transactions = Transactions::where('order_id', $order_id)->get();
        $total_biaya = 0;

        foreach($transactions as $transaction){
            $total_price = $transaction->price * $transaction->quantity;
            $total_biaya += $total_price;
        }

        return view('receipt', compact('transactions', 'total_biaya'));
    }
}