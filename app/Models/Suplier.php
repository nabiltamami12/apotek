<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    protected $table = 'suplier'; 

    protected $fillable = [
    			'kode', 'nama', 'alamat', 'telp', 'norek', 'bank', 'bank_pemilik', 'email', 'aktif'
    		];
 
	public function sementara() {
    	return $this->hasMany('App\Models\Sementara');
    }
	
	
}
