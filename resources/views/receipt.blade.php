@php
    function rupiah($angka){
        $hasil_rupiah = "Rp" . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>e-Receipt #{{ $transactions[0]->order_id }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <main class="py-4">
            <div class="card">
                <div class="card-header px-5">
                    <h3 style="font-size: 50px">e-Receipt #{{ $transactions[0]->order_id }}</h3>
                    <span class="text-secondary" style="font-size: 30px">{{ $transactions[0]->created_at }}</span>
                </div>
                <div class="card-body px-5">
                    @foreach ($transactions as $transaction )
                        <div class="row" style="font-size: 30px">
                            <div class="col">
                                {{ $transaction->product->name }}
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-2">
                                        {{ $transaction->quantity }} x
                                    </div>
                                    <div class="col-10 text-end">
                                        {{ rupiah($transaction->price) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer px-5">
                    <div style="font-size: 50px">
                        <div class="row">
                            <div class="col">
                                Total:
                            </div>
                            <div class="col text-end">
                                {{ rupiah($total_biaya) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
