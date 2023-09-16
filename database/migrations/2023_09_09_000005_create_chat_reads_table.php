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
        Schema::create('chat_reads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chats_angkatan_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('angkatan');
            $table->string('tipe_angkatan');
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
        Schema::dropIfExists('chat_reads');
    }
};
