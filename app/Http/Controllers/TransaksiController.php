<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksi = Transaksi::all();
        return view('transaksi.index', compact('transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data produk dari database
        $produk = Produk::all();
        return view('transaksi.create', compact('produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data transaksi
        $validated = $request->validate([
            'kode_transaksi' => 'required|string|max:255|unique:transaksis',
            'total_harga' => 'required|numeric|min:0',
        ]);

        // Menyimpan transaksi utama
        $transaksi = Transaksi::create([
            'kode_transaksi' => $validated['kode_transaksi'],
            'total_harga' => $validated['total_harga'],
        ]);

        // Menyimpan detail transaksi menggunakan TransactionDetailController
        foreach ($request->produk_id as $index => $produk_id) {
            // Kirim request ke TransactionDetailController untuk menyimpan detail transaksi
            $transactionDetailController = new TransactionDetailController();
            $transactionDetailController->store(new Request([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $produk_id,
                'jumlah' => $request->jumlah[$index],
            ]));
        }

        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
        }

        return redirect()->route('kasir.transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = Transaksi::with('transactionDetails.produk')->findOrFail($id);

        // Ambil nama kasir (user yang sedang login)
        $kasir = Auth::user()->name; // Asumsi nama kolom di tabel users adalah 'name'

        // Kirim data transaksi dan kasir ke view
        return view('transaksi.show', compact('transaksi', 'kasir'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
