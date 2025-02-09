<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id', // transaksi_id harus ada di tabel 'transaksis'
            'produk_id' => 'required|exists:produks,id', // produk_id harus ada di tabel 'produks'
            'jumlah' => 'required|integer|min:1', // jumlah harus berupa angka minimal 1
        ]);

        // Cari produk berdasarkan produk_id yang divalidasi
        $product = Produk::find($validated['produk_id']);

        // Cek apakah stok produk mencukupi
        if ($product->stok < $validated['jumlah']) {
            // Jika stok tidak mencukupi, kembalikan ke halaman sebelumnya dengan pesan error
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        // Kurangi stok produk sesuai jumlah yang dipesan
        $product->decrement('stok', $validated['jumlah']);

        // Simpan data transaksi baru di tabel 'TransactionDetail'
        TransactionDetail::create([
            'transaksi_id' => $validated['transaksi_id'], // ID transaksi
            'produk_id' => $validated['produk_id'], // ID produk
            'jumlah' => $validated['jumlah'], // Jumlah produk yang dibeli
            'subtotal' => $product->harga * $validated['jumlah'], // Total harga berdasarkan harga produk
        ]);

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Detail transaksi berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(TransactionDetail $transactionDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionDetail $transactionDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionDetail $transactionDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionDetail $transactionDetail)
    {
        //
    }
}
