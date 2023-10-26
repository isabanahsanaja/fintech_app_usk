<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallets;
use App\Models\Category;
use App\Models\Products;
use App\Models\Students;
use App\Models\Transactions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FirstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => "Admin",
            'username' => "admin",
            'password' => Hash::make('123'),
            'role' => "admin"
        ]);
        User::create([
            'name' => "Tenizen Bank",
            'username' => "bank",
            'password' => Hash::make('123'),
            'role' => "bank"
        ]);
        User::create([
            'name' => "Tenizen Kantin",
            'username' => "kantin",
            'password' => Hash::make('123'),
            'role' => "kantin"
        ]);
        User::create([
            'name' => "Syarif",
            'username' => "syarif",
            'password' => Hash::make('1234'),
            'role' => "siswa"
        ]);

        Students::create([
            'user_id' => "4",
            'nis' => 12345,
            'classroom' => "XII RPL"
        ]);

        Category::create([
            'name' => "Minuman"
        ]);

        Category::create([
            'name' => "Makanan"
        ]);

        Category::create([
            'name' => "Snack"
        ]);

        Products::create([
            'name' => "Orange",
            'price' => "5000",
            'stock' => 100,
            'photo' => "img/jerukes.png",
            'description' => "Es Jeruk",
            'category_id' => 3,
            'stand' => 2
        ]);

        Products::create([
            'name' => "Lemonade",
            'price' => "10000",
            'stock' => 50,
            'photo' => "img/lemonade.png",
            "description" => "Es Lemon",
            'category_id' => 3,
            'stand' => 1,
           
        ]);

        Products::create([
            'name' => "Risoles",
            'price' => "3000",
            'stock' => 50,
            'photo' => "img/risoles.png",
            "description" => "Risol Mayo",
            'category_id' => 3,
            'stand' => 1,
           
        ]);

        Products::create([
            'name' => "Oden",
            'price' => "15000",
            'stock' => 50,
            'photo' => "img/oden.png",
            "description" => "Oden Segar",
            'category_id' => 3,
            'stand' => 1,
           
        ]);

        Products::create([
            'name' => "Donut",
            'price' => "8000",
            'stock' => 50,
            'photo' => "img/donut.png",
            "description" => "Donut Gula",
            'category_id' => 3,
            'stand' => 2,
           
        ]);

        Products::create([
            'name' => "Bakso Bakar",
            'price' => "3000",
            'stock' => 50,
            'photo' => "img/bakso.png",
            "description" => "Bakso Bakar Hot",
            'category_id' => 3,
            'stand' => 2,
           
        ]);

        Wallets::create([
            'user_id' => 4,
            'credit' => 100000,
            'debit' => null,
            'description' => "Pembukaan tabungan"
        ]);

        Wallets::create([
            'user_id' => 4,
            'credit' => 15000,
            'debit' => null,
            'description' => "Pembelian"
        ]);

        Wallets::create([
            'user_id' => 4,
            'credit' => null,
            'debit' => 21000,
            'description' => "Pembelian"
        ]);

        Transactions::create([
            'user_id' =>  4,
            'product_id' => 1,
            'status' => 'di keranjang',
            'order_id' => 'INV_12345',
            'price' => 5000,
            'quantity' => 1
        ]);

        Transactions::create([
            'user_id' =>  4,
            'product_id' => 2,
            'status' => 'di keranjang',
            'order_id' => 'INV_12345',
            'price' => 10000,
            'quantity' => 1
        ]);

        Transactions::create([
            'user_id' =>  4,
            'product_id' => 3,
            'status' => 'di keranjang',
            'order_id' => 'INV_12345',
            'price' => 3000,
            'quantity' => 2
        ]);

        $total_debit = 0;

        $transactions = Transactions::where('order_id' ==
        'INV_12345');

        foreach($transactions as $transaction)
        {
            $total_price = $transaction->price * $transaction->quantity;
            $total_debit += $total_price;
        }

        Wallets::create([
            'user_id' => 4,
            'debit' => $total_debit,
            'description' => "Pembelian Product"
        ]);

        foreach($transactions as $transaction)
        {
            Transactions::find($transaction->id)->update([
                'status' => 'dibayar'
            ]);
        }
        foreach($transactions as $transaction)
        {
            Transactions::find($transaction->id)->update([
                'status' => 'diambil'
            ]);
        }
        foreach($transactions as $transaction)
        {
            Transactions::find($transaction->id)->update([
                'status' => 'di keranjang'
            ]);
        }
    }
}