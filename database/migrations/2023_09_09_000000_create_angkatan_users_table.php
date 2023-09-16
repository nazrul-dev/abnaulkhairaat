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
        Schema::create('angkatan_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('angkatan');
            $table->enum('tipe_angkatan', ['mi', 'mts', 'ma']);
            $table->integer('tahun_kelulusan');
            $table->unsignedBigInteger('user_id')->nullable();

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
        Schema::dropIfExists('angkatan_users');
    }
};
