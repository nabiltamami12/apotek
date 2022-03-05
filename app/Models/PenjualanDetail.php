<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $table = 'penjualan_detail';
	
    protected $fillable = ['penjualan_id', 'barang_id', 'harga_beli', 'jumlah', 'harga_jual', 'harga_jual_3'];

    public function penjualan() {
    	return $this->belongsTo('App\Models\Penjualan');
    }

    public function barang() {
    	return $this->belongsTo('App\Models\Barang');
    }
}
