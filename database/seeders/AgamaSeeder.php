<?php

namespace Database\Seeders;

use App\Models\Agama;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_agama = ["Kristen","Islam","Buddha","Hindu"];

        foreach ($data_agama as $key => $value) {
            $agama = new Agama();
            $agama->agama = $value;
            $agama->save();
        }
    }
}
