<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->String('nomor_surat',30)->primary();
            $table->String('perihal');
            $table->enum('jenis_surat', array('Keluar Dekan','Keluar Wakil Dekan','Keluar Kaprodi Magister Bioteknologi','Kerja Sama','Keputusan Dekan'));
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
        Schema::dropIfExists('surats');
    }
}
