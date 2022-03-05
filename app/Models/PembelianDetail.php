<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    protected $table = 'pembelian_detail';

    protected $fillable = ['pembelian_id', 'barang_id', 'harga', 'jumlah'];

    public function pembelian() {
    	return $this->belongsTo('App\Models\Pembelian');
    }

    public function barang() {
    	return $this->belongsTo('App\Models\Barang');
    }
}
