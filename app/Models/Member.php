<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';

    protected $fillable = ['kode', 'gsm', 'alamat', 'nama', 'level', 'aktif'];

    public function penjualan() {
        return $this->hasMany('App\Models\Penjualan');
    }
}
