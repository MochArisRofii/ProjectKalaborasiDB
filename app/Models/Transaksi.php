<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['kode_transaksi', 'total_harga'];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function produk()
    {
        return $this->belongsToMany(Produk::class)->withPivot('jumlah');
    }

    // Relasi dengan pelanggan
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
