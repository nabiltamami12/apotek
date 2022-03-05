<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'admin' => [
            	'fullname'=>'Administrator',
            	'password' => bcrypt('admin'),
            	'active'=>true
            ], 
            'super' => [
            	'fullname'=>'Super User',
            	'password' => bcrypt('super'),
            	'active'=>true
            ]
        ];


        foreach($data as $i=>$d) {
            $ada = User::where('username', $i)->first();
            if ($ada == null) {
                $ada = new User;
                $ada->username = $i;
                $ada->fullname = $d['fullname'];
            	$ada->password = $d['password'];
            	$ada->active = $d['active'];
                $ada->save();
            }
        }
    }
}
