<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembangunans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->dateTime('tanggal_pembangunan');
            $table->mediumText('keterangan')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table
                ->enum('status', ['MULAI', 'PROSES', 'SELESAI'])
                ->default('MULAI');
            $table->string('image')->nullable();

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
        Schema::dropIfExists('pembangunans');
    }
};
