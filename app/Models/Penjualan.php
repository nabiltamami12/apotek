<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
	
    protected $fillable = ['kode', 'user_id', 'bayar', 'member_id',  'tipe_bayar', 'nomor_kartu', 'who_shop', 'catatan', 'tgl'];

    protected $dates = array('tgl');

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function member() {
        return $this->belongsTo('App\Models\Member');
    }

    public function penjualandetail() {
        return $this->hasMany('App\Models\PenjualanDetail');
    }

    public function total() {
    	$details = $this->penjualandetail;

    	$t = 0;
    	foreach ($details as $key => $value) {
    		$t += $value->jumlah * $value->harga_jual;
    	}

    	return $t;
    }

    public function keuntungan() {
        $details = $this->penjualandetail;

        $t = 0;
        foreach ($details as $key => $value) {
            $t += ($value->jumlah * $value->harga_jual) - ($value->jumlah * $value->harga_beli);
        }

        return $t;
    }

    public function keuntunganrata() {
        $details = $this->penjualandetail;

        $t = 0;
        foreach ($details as $key => $value) {
            $t += ($value->jumlah * $value->harga_jual_3) - ($value->jumlah * $value->harga_beli);
        }

        return $t;
    }
}
