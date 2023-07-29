<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas_ulangans', function (Blueprint $table) {
            $table->id();
            $table->integer("jadwal_pelajaran_id");
            $table->integer("kelas_id");
            $table->string("judul");
            $table->string("mulai");
            $table->string("selesai");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tugas_ulangans');
    }
};
