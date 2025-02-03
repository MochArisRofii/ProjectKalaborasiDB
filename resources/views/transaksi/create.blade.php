@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="container-1 mt-5">
    <h1 class="text-white mb-4">Tambah Transaksi</h1>
    <form action="{{ route(auth()->user()->role == 'admin' ? 'transaksi.store' : 'kasir.transaksi.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="kode_transaksi" class="form-label text-white">Kode Transaksi</label>
            <input type="text" class="form-control" name="kode_transaksi" id="kode_transaksi" value="{{ 'TRX-' . time() }}" readonly>
        </div>

        <div id="product-list">
            <div class="product-item mb-4">
                <label for="produk_id_0" class="form-label text-white">Produk</label>
                <select name="produk_id[]" id="produk_id_0" class="form-select produk-select" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($produk as $produk)
                    <option value="{{ $produk->id }}" data-harga="{{ $produk->harga }}">
                        {{ $produk->nama_produk }} (Stok: {{ $produk->stok }})
                    </option>
                    @endforeach
                </select>

                <label for="jumlah_0" class="form-label mt-3 text-white">Jumlah</label>
                <input type="number" name="jumlah[]" id="jumlah_0" class="form-control jumlah-input" min="1" required>

                <label for="subtotal_0" class="form-label mt-3 text-white">Subtotal</label>
                <input type="text" name="subtotal[]" id="subtotal_0" class="form-control subtotal-input" readonly>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mb-3" id="add-product">
            <i class="fas fa-plus-circle"></i> Tambah Produk
        </button>

        <div class="mb-4">
            <label for="total_harga" class="form-label text-white">Total Harga</label>
            <input type="text" class="form-control" name="total_harga" id="total_harga" readonly>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">Simpan Transaksi</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let productIndex = 1;

        // Fungsi untuk menambahkan produk
        document.getElementById('add-product').addEventListener('click', function () {
            const productList = document.getElementById('product-list');
            const newProduct = document.querySelector('.product-item').cloneNode(true);

            newProduct.querySelectorAll('input, select').forEach(function (input) {
                input.id = input.id.replace(/\d+/, productIndex);
                input.name = input.name.replace(/\[\d*\]/, `[${productIndex}]`);
                input.value = '';
            });

            productList.appendChild(newProduct);
            productIndex++;
        });

        // Fungsi untuk menghitung subtotal dan total harga
        document.addEventListener('input', function (event) {
            if (event.target.classList.contains('jumlah-input') || event.target.classList.contains('produk-select')) {
                const productItem = event.target.closest('.product-item');
                const harga = productItem.querySelector('.produk-select option:checked').dataset.harga || 0;
                const jumlah = productItem.querySelector('.jumlah-input').value || 0;

                const subtotal = harga * jumlah;
                productItem.querySelector('.subtotal-input').value = subtotal.toFixed(2);

                // Hitung total harga
                let totalHarga = 0;
                document.querySelectorAll('.subtotal-input').forEach(function (input) {
                    totalHarga += parseFloat(input.value) || 0;
                });
                document.getElementById('total_harga').value = totalHarga.toFixed(2);
            }
        });
    });
</script>

<style>
    /* Styling form */
    .container-1 {
        max-width: 600px;
        margin: 0 auto;
        padding: 30px;
        background-color: #2a2a2a;
        border-radius: 10px;
    }

    h1 {
        font-size: 1.8rem;
        font-weight: 600;
    }

    .form-label {
        font-size: 1rem;
        font-weight: 500;
    }

    .form-control {
        font-size: 1rem;
        padding: 10px;
        border-radius: 10px;
        background-color: #333;
        color: #fff;
        border: 1px solid #444;
    }

    .form-control:focus {
        border-color: #5cb85c;
        box-shadow: 0 0 5px rgba(92, 184, 92, 0.5);
    }

    .form-select {
        font-size: 1rem;
        padding: 10px;
        border-radius: 10px;
        background-color: #333;
        color: #fff;
        border: 1px solid #444;
    }

    .form-select:focus {
        border-color: #5cb85c;
        box-shadow: 0 0 5px rgba(92, 184, 92, 0.5);
    }

    .btn {
        font-size: 1rem;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #5a6268;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .product-item {
        padding: 15px;
        background-color: #3a3a3a;
        border-radius: 10px;
    }

    .product-item + .product-item {
        margin-top: 20px;
    }

    .mb-4 {
        margin-bottom: 20px !important;
    }

    #add-product {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
        font-size: 1rem;
        padding: 10px 20px;
        border-radius: 30px;
    }

    #add-product:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>
@endsection
