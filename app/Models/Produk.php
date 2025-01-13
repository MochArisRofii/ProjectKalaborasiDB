<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['nama_produk', 'deskripsi', 'stok', 'harga'];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function transaksi()
    {
        return $this->belongsToMany(Transaksi::class)->withPivot('jumlah');
    }
}
