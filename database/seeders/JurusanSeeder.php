<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jurusan = new Jurusan();
        $jurusan->jurusan = "ipa";
        $jurusan->save();

        $jurusan = new Jurusan();
        $jurusan->jurusan = "ips";
        $jurusan->save();

        $jurusan = new Jurusan();
        $jurusan->jurusan = "tata boga";
        $jurusan->save();
    }
}
