<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';

    protected $fillable = ['tgl', 'kode', 'user_id'];

    protected $dates = array('tgl');

    public function pembeliandetail() {
        return $this->hasMany('App\Models\PembelianDetail');
    }

    public function total() {
    	$details = $this->pembeliandetail;

    	$t = 0;
    	foreach ($details as $key => $value) {
    		$t += $value->jumlah * $value->harga;
    	}

    	return $t;
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
