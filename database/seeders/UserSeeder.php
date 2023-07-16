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
        for ($i = 1; $i <= 20; $i++) {
            $user = new User();
            $user->nama = "User $i";
            $user->username = "user$i";
            $user->role_id = random_int(1, 5);
            $user->alamat = "alamat$i";
            $user->no_hp = "kontak$i";
            $user->password  = bcrypt("1");
            $user->save();
        }
    }
}
