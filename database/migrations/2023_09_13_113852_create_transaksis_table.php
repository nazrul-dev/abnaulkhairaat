<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe_donasi', ['event','pembagunan', 'donasi'])->default('donasi');
            $table->string('relation_id')->nullable();
            $table->string('qr_url')->nullabe();
            $table->double('jumlah_donasi')->default(0);
            $table->double('biaya_admin')->default(0);
            $table->double('total_donasi')->default(0);
            $table->string('merchant_ref');
            $table->string('expired_time');
            $table->string('status')->default('UNPAID');
            $table->string('reference');
            $table->string('payment_method');
            $table->string('payment_name');
            $table->string('pay_code')->nullabe();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};


// reference	:	DEV-T24742120666R10LD
// merchant_ref	:	DT-1694604762
// payment_selection_type	:	static
// payment_method	:	BCAVA
// payment_name	:	BCA Virtual Account
// customer_name	:	Gwendolyn Roob
// customer_email	:	rmetz@example.org
// customer_phone	:	null
// callback_url	:	null
// return_url	:	null
// amount	:	90000
// fee_merchant	:	5500
// fee_customer	:	0
// total_fee	:	5500
// amount_received	:	84500
// pay_code	:	408962165557372
// pay_url	:	null
// checkout_url	:	https://tripay.co.id/checkout/DEV-T24742120666R10LD
// status	:	UNPAID
// expired_time	:	1694626362
