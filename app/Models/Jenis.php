<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    protected $table = 'jenis';

    protected $fillable = ['nama'];

    public function barang() {
    	return $this->hasMany('App\Models\Barang');
    }
}
