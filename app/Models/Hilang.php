<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hilang extends Model
{
	protected $table = 'hilang';

    protected $fillable = ['id', 'barang_id', 'jumlah'];

    public function barang() {
    	return $this->belongsTo('App\Models\Barang', 'barang_id');
    }

    public function opname() {
    	return $this->hasOne("App\Models\Opname", 'id');
    }
}
