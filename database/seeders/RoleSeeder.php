<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->nama = "admin";
        $role->save();

        $role = new Role();
        $role->nama = "kepala sekolah";
        $role->save();

        $role = new Role();
        $role->nama = "guru";
        $role->save();

        $role = new Role();
        $role->nama = "murid";
        $role->save();

        $role = new Role();
        $role->nama = "wali murid";
        $role->save();
    }
}
