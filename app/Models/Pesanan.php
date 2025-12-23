<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';

    protected $fillable = [
        'user_id',
        'produk_id',
        'nama_penerima',
        'no_hp',
        'metode_pembayaran',
        'catatan_pembeli',
        'jumlah',
        'total',
        'status',
        'alamat',
    ];
}
