<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->nama = "Admin";
        $user->username = "admin";
        $user->role_id = 1;
        $user->alamat = "alamat admin";
        $user->no_hp = "kontak admin";
        $user->password  = bcrypt("1");
        $user->save();

        $user = new User();
        $user->nama = "Kepala Sekolah";
        $user->username = "kepala_sekolah";
        $user->role_id = 2;
        $user->alamat = "alamat kepala sekolah";
        $user->no_hp = "kontak kepala sekolah";
        $user->password  = bcrypt("1");
        $user->save();
        
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->nama = "Guru $i";
            $user->username = "guru$i";
            $user->role_id = 3;
            $user->alamat = "alamat guru $i";
            $user->no_hp = "kontak guru $i";
            $user->password  = bcrypt("1");
            $user->save();
        }
    }
}
