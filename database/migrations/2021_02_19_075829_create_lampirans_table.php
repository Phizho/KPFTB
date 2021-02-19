<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLampiransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lampirans', function (Blueprint $table) {
            $table->id();
            $table->String('nomor_surat', 30);
            $table->index('nomor_surat');
            $table->foreign('nomor_surat')->references('nomor_surat')->on('surats')->onDelete('cascade');
            $table->String('nama_lampiran', 50);
            $table->String('format_lampiran', 6);
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
        Schema::dropIfExists('lampirans');
    }
}
