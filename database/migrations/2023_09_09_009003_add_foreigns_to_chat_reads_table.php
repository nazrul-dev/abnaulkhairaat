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
        Schema::table('chat_reads', function (Blueprint $table) {
            $table
                ->foreign('chats_angkatan_id')
                ->references('id')
                ->on('chats_angkatans')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_reads', function (Blueprint $table) {
            $table->dropForeign(['chats_angkatan_id']);
            $table->dropForeign(['user_id']);
        });
    }
};
