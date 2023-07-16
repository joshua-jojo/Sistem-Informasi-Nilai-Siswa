<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jurusan  = Jurusan::all();
        $jumlah_jurusan = count($jurusan);
        for ($i = 1; $i <= 20; $i++) {
            $kelas = new Kelas();
            $kelas->kelas = "kelas $i";
            $kelas->jurusan_id = rand(1,$jumlah_jurusan);
            $kelas->save();
        }
    }
}
