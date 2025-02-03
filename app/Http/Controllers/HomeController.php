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
        // Ambil semua data produk
        $produk = Produk::all();

        // Data untuk Chart Pie
        $produkLabels = $produk->pluck('nama_produk')->toArray(); // Nama produk
        $produkStok = $produk->pluck('stok')->toArray(); // Stok produk

        // Ambil data jumlah terjual dari TransactionDetail
        $jumlahTerjual = TransactionDetail::selectRaw('produk_id, SUM(jumlah) as total_terjual')
            ->groupBy('produk_id')
            ->get();

        // Data untuk Chart Donut (Produk Terjual)
        $produkTerjualLabels = [];
        $produkTerjualJumlah = [];

        foreach ($jumlahTerjual as $detail) {
            // Ambil nama produk berdasarkan produk_id
            $produkTerjualLabels[] = $detail->produk->nama_produk;
            // Ambil total jumlah terjual
            $produkTerjualJumlah[] = $detail->total_terjual;
        }

        return view('home', compact('produkLabels', 'produkStok', 'produkTerjualLabels', 'produkTerjualJumlah'));
    }
}
