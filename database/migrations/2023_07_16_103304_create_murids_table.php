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
        Schema::create('murids', function (Blueprint $table) {
            $table->id();
            $table->string("nis")->nullable();
            $table->string("tanggal_lahir")->nullable();
            $table->string("agama")->nullable();
            $table->integer("user_id")->nullable();
            $table->integer("kelas_id")->nullable();
            $table->integer("jurusan_id")->nullable();
            $table->integer("wali_murid")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('murids');
    }
};
