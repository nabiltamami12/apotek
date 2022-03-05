<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sementara extends Model
{
    protected $table = 'sementara';

    protected $fillable = ['kode', 'harga', 'jumlah', 'barang_id', 'suplier_id'];

    public function barang() {
    	return $this->belongsTo('App\Models\Barang');
    }
	
	public function suplier() {
    	return $this->belongsTo('App\Models\Suplier');
    }
}
