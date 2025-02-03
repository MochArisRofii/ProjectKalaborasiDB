@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Transaksi</h1>
        <a href="{{ auth()->user()->role === 'admin' ? route('transaksi.create') : route('kasir.transaksi.create') }}"
            class="btn btn-success">Tambah Transaksi</a>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Kode Transaksi</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $item)
                <tr>
                    <td style="color: white;">{{ $item->kode_transaksi }}</td>
                    <td style="color: white;">Rp. {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    <td style="color: white;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td> 
                    <td>
                        <a href="{{ auth()->user()->role === 'admin' ? route('transaksi.show', $item->id) : route('kasir.transaksi.show', $item->id) }}"
                            class="btn btn-info btn-sm">Detail</a>
                        @if (auth()->user()->role == 'admin')
                            <form action="{{ route('transaksi.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
