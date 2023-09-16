<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biodata', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone');
            $table->string('phone_wa');
            $table->enum('status_hubungan', [
                'Lajang',
                'Duda',
                'Janda',
                'Menikah',
            ]);
            $table->text('current_address');
            $table->text('city');
            $table->text('province');
            $table->text('district');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('pekerjaan')->nullable();
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
        Schema::dropIfExists('biodata');
    }
};
