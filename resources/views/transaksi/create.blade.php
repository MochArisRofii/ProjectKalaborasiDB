@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
<h1>Tambah Transaksi</h1>
<form action="{{ route('transaksi.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="kode_transaksi" class="form-label">Kode Transaksi</label>
        <input type="text" class="form-control" name="kode_transaksi" id="kode_transaksi" value="{{ 'TRX-' . time() }}" readonly>
    </div>

    <div id="product-list">
        <div class="product-item mb-3">
            <label for="produk_id_0" class="form-label">Produk</label>
            <select name="produk_id[]" id="produk_id_0" class="form-select produk-select" required>
                <option value="">-- Pilih Produk --</option>
                @foreach ($produk as $produk)
                <option value="{{ $produk->id }}" data-harga="{{ $produk->harga }}">
                    {{ $produk->nama_produk }} (Stok: {{ $produk->stok }})
                </option>
                @endforeach
            </select>

            <label for="jumlah_0" class="form-label mt-2">Jumlah</label>
            <input type="number" name="jumlah[]" id="jumlah_0" class="form-control jumlah-input" min="1" required>

            <label for="subtotal_0" class="form-label mt-2">Subtotal</label>
            <input type="text" name="subtotal[]" id="subtotal_0" class="form-control subtotal-input" readonly>
        </div>
    </div>

    <button type="button" class="btn btn-secondary mb-3" id="add-product">Tambah Produk</button>

    <div class="mb-3">
        <label for="total_harga" class="form-label">Total Harga</label>
        <input type="text" class="form-control" name="total_harga" id="total_harga" readonly>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
</form>


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
@endsection
