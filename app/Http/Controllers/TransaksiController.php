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
        $produks = Produk::all();
        return view('transaksi.create', compact('produks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data transaksi dari request
        $validated = $request->validate([
            'kode_transaksi' => 'required|string|max:255|unique:transaksis', // Kode transaksi wajib, unik, dan maksimal 255 karakter
            'total_harga' => 'required|numeric|min:0', // Total harga harus angka dan minimal 0
            'produk_id' => 'required|array|min:1', // Harus ada minimal 1 produk yang dipilih
            'produk_id.*' => 'required|exists:produks,id', // Setiap produk yang dipilih harus ada di tabel 'produks'
            'jumlah' => 'required|array|min:1', // Jumlah produk harus berbentuk array dan minimal 1
            'jumlah.*' => 'required|numeric|min:1', // Setiap jumlah produk harus lebih dari 0
        ]);

        // Periksa stok produk sebelum menyimpan transaksi
        foreach ($request->produk_id as $index => $produk_id) {
            $produk = Produk::find($produk_id); // Cari produk berdasarkan ID
            $jumlah = $request->jumlah[$index]; // Ambil jumlah produk yang ingin dibeli

            // Jika jumlah yang dibeli lebih besar dari stok yang tersedia, kirim error
            if ($jumlah > $produk->stok) {
                return redirect()->back()->withErrors([
                    'produk_id.' . $index => 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi. Stok tersedia: ' . $produk->stok
                ])->withInput();
            }
        }

        // Simpan data transaksi ke dalam database
        $transaksi = Transaksi::create([
            'kode_transaksi' => $validated['kode_transaksi'], // Simpan kode transaksi
            'total_harga' => $validated['total_harga'], // Simpan total harga transaksi
        ]);

        // Simpan detail transaksi untuk setiap produk yang dibeli
        foreach ($request->produk_id as $index => $produk_id) {
            // Membuat instance TransactionDetailController untuk menyimpan data detail transaksi
            $transactionDetailController = new TransactionDetailController();
            $transactionDetailController->store(new Request([
                'transaksi_id' => $transaksi->id, // ID transaksi yang baru dibuat
                'produk_id' => $produk_id, // ID produk yang dibeli
                'jumlah' => $request->jumlah[$index], // Jumlah produk yang dibeli
            ]));
        }

        // Redirect ke halaman yang sesuai berdasarkan role pengguna
        if (auth()->user()->role == 'admin') {
            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat.'); // Jika admin, ke daftar transaksi
        }

        return redirect()->route('kasir.transaksi.index')->with('success', 'Transaksi berhasil dibuat.'); // Jika kasir, ke halaman kasir
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

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
