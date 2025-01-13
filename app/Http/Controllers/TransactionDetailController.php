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
        $validated = $request->validate([
            'transaksi_id' => 'required|exists:transaksis,id',
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $product = Produk::find($validated['produk_id']);
        if ($product->stok < $validated['jumlah']) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $product->decrement('stok', $validated['jumlah']);

        TransactionDetail::create([
            'transaksi_id' => $validated['transaksi_id'],
            'produk_id' => $validated['produk_id'],
            'jumlah' => $validated['jumlah'],
            'subtotal' => $product->harga * $validated['jumlah'],
        ]);

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
