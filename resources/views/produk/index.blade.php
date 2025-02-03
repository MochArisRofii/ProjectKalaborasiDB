@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Daftar Produk</h1>
    @if (auth()->user()->role == 'admin')
    <a href="{{ route('produk.create') }}" class="btn btn-success">Tambah Produk</a>
    @endif
</div>

<table class="table table-striped table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Nama Produk</th>
            <th>Stok</th>
            <th>Harga</th>
            @if (auth()->user()->role == 'admin')
            <th>Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($produk as $item)
        <tr>
            <td style="color: white;">{{ $item->nama_produk }}</td>
            <td style="color: white;">{{ $item->stok }}</td>
            <td style="color: white;"> Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
            @if(auth()->user()->role == 'admin')
            <td>
                <a href="{{ route('produk.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('produk.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
