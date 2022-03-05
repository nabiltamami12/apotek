<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner = Role::where('name', 'owner')->first();
        if ($owner == null) {
            $owner = new Role();
            $owner->name         = 'owner';
            $owner->display_name = 'Pembuat Aplikasi'; // optional
            $owner->description  = 'Grup Pengguna untuk pembuat aplikasi ini'; // optional
            $owner->save();

            $userOwner = User::where('username', 'super')->first();
            $userOwner->attachRole($owner);
        }

        $admin = Role::where('name', 'admin')->first();
        if ($admin == null) {
            $admin = new Role();
            $admin->name         = 'admin';
            $admin->display_name = 'Administrator'; // optional
            $admin->description  = 'Grup Pengguna yang mempunyai hak untuk semuanya'; // optional
            $admin->save();

            $userAdmin = User::where('username', 'admin')->first();
            $userAdmin->attachRole($admin);
        }

        $kasir = Role::where('name', 'kasir')->first();
        if ($kasir == null) {
            $kasir = new Role();
            $kasir->name         = 'kasir';
            $kasir->display_name = 'Kasir Perusahaan'; // optional
            $kasir->description  = 'Grup Pengguna untuk kasir perusahaan ini';
            $kasir->save();
        }
    }
}
