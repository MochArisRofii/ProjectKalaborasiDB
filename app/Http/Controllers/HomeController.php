<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Ambil semua data produk dari tabel 'produk'
        $produk = Produk::all();

        // Data untuk Chart Pie (Diagram Lingkaran)
        // Mengambil semua nama produk dalam bentuk array
        $produkLabels = $produk->pluck('nama_produk')->toArray();
        // Mengambil semua stok produk dalam bentuk array
        $produkStok = $produk->pluck('stok')->toArray();

        // Ambil data jumlah produk yang telah terjual dari tabel 'TransactionDetail'
        $jumlahTerjual = TransactionDetail::selectRaw('produk_id, SUM(jumlah) as total_terjual')
            ->groupBy('produk_id') // Kelompokkan berdasarkan produk_id
            ->get();

        // Data untuk Chart Donut (Produk Terjual)
        $produkTerjualLabels = []; // Menyimpan label nama produk yang terjual
        $produkTerjualJumlah = []; // Menyimpan jumlah produk yang terjual

        foreach ($jumlahTerjual as $detail) {
            // Ambil nama produk berdasarkan produk_id dari relasi
            $produkTerjualLabels[] = $detail->produk->nama_produk;
            // Ambil total jumlah terjual berdasarkan hasil query
            $produkTerjualJumlah[] = $detail->total_terjual;
        }

        // Kirim data ke view 'home'
        return view('home', compact('produkLabels', 'produkStok', 'produkTerjualLabels', 'produkTerjualJumlah'));
    }

}
