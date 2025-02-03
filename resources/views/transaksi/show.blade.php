@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Nota Transaksi</h1>

        <div class="mb-3">
            <strong>Kode Transaksi:</strong> <span class="text-primary">{{ $transaksi->kode_transaksi }}</span>
        </div>

        <div class="mb-3">
            <strong>Total Harga:</strong> <span class="text-success">Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>

        <div class="mb-3">
            <strong>Tanggal Transaksi:</strong> <span class="text-info">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y') }}</span>
        </div>

        <div class="mb-4">
            <strong>Kasir:</strong> {{ $kasir }}
        </div>

        <h3 class="text-center mb-4">Detail Produk</h3>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->transactionDetails as $detail)
                    <tr>
                        <td style="color: white;">{{ $detail->produk->nama_produk }}</td>
                        <td style="color: white;">{{ $detail->jumlah }}</td>
                        <td style="color: white;">Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center">
            <button onclick="window.print()" class="btn btn-primary mt-3">Cetak Nota</button>
            <a href="{{ auth()->user()->role === 'admin' ? route('transaksi.index') : route('kasir.transaksi.index') }}"
                class="btn btn-secondary mt-3">Kembali ke Daftar Transaksi</a>
        </div>
    </div>

    <!-- Nota Print Style -->
    <style>
        @media print {
            body {
                font-family: 'Arial', sans-serif;
                margin: 0;
                padding: 0;
                width: 100%;
                background-color: #f4f4f4;
            }

            .container {
                width: 100%;
                max-width: 600px;
                margin: auto;
                padding: 30px;
                background-color: #fff;
                border: 1px solid #ccc;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .container h1,
            .container h3 {
                text-align: center;
                color: #333;
            }

            .container .table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            .container .table,
            .container th,
            .container td {
                border: 1px solid #ddd;
            }

            .container th,
            .container td {
                padding: 12px;
                text-align: left;
                font-size: 14px;
            }

            .container th {
                background-color: #343a40;
                color: #fff;
            }

            .container td {
                background-color: #f9f9f9;
            }

            .container .btn {
                display: none;
                /* Hide buttons during print */
            }

            .container .mb-3 {
                margin-bottom: 20px;
            }

            /* Styling improvements for print */
            .container h1 {
                font-size: 24px;
                margin-bottom: 30px;
            }

            .container h3 {
                font-size: 20px;
                margin-bottom: 20px;
            }

            .container .table th,
            .container .table td {
                font-size: 16px;
            }

            .container .table td {
                padding: 10px;
            }

            .container .table th {
                background-color: #0056b3;
                color: white;
            }

            .container .table td {
                background-color: #f8f9fa;
            }

            .container .text-info {
                font-weight: bold;
            }

            .container .text-primary,
            .container .text-success {
                font-weight: bold;
            }
        }
    </style>
@endsection
    