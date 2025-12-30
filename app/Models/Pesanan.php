<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

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
        'ekspedisi',
        'ongkir',
        'resi',
        'snap_token',
    ];

    /**
     * Get the user that owns the pesanan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the produk that belongs to the pesanan
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
