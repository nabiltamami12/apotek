<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Notifiable,Authorizable, EntrustUserTrait {
        EntrustUserTrait::can insteadof Authorizable;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname', 'username', 'password','active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $role_name = null;


    public function permissions() {
        $role_user = AssignedRole::where('user_id', $this->id)->first();
        $role = Role::where('id', $role_user->role_id)->first();

        return $role->perms;
    }

    public function role() {
        $role_user = AssignedRole::where('user_id', $this->id)->first();
        $role = Role::where('id', $role_user->role_id)->first();

        return $role;
    }

    public function loadTambahan() {
        if ($this->role_name == null) {
            $this->role_name  = $this->role()->display_name;
        }
    }

    public function pembelian() {
        return $this->hasMany('App\Models\Pembelian');
    }

    public function penjualan() {
        return $this->hasMany('App\Models\Penjualan');
    }

    public function opname() {
        return $this->hasMany('App\Models\Opname');
    }

    public function history() {
        return $this->hasMany('App\Models\History');
    }
}
