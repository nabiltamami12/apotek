<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opname extends Model
{
	protected $table = 'opname';

    protected $fillable = ['kode', 'tgl', 'user_id', 'barang_id', 'stok', 'stok_nyata', 'selisih', 'keterangan'];

    protected $dates = array('tgl');

    public function barang() {
    	return $this->belongsTo('App\Models\Barang');
    }

    public function hilang() {
        return $this->belongsTo("App\Models\Hilang", 'id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
