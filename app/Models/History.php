<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
	protected $table = 'history';

    protected $fillable = ['nama', 'kode','tgl', 'barang_id', 'stok', 'masuk', 'keluar', 'saldo', 'user_id', 'keterangan'];

    protected $dates = array('tgl');

	public function barang() {
    	return $this->belongsTo('App\Models\Barang');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
