<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public $banyakpengguna = null;

    protected $fillable = ['name', 'display_name', 'description'];

    public function loadTambahan() {
        if ($this->banyakpengguna === null) {
            $this->banyakpengguna = count($this->users()->get());
        }
    }
}
