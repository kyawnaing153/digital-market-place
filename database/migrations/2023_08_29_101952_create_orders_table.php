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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('tnx_id')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_name')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_province')->nullable();
            $table->string('billing_postalcode')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('billing_name_on_card')->nullable();
            $table->integer('billing_discount')->default(0);
            $table->string('billing_discount_code')->nullable();
            $table->integer('billing_subtotal');
            $table->integer('billing_tax')->nullable();
            $table->integer('billing_total');
            $table->string('payment_gateway')->nullable();
            $table->string('mode')->nullable();
            $table->string('status')->default(1)->comment('1 for success 0 for pending 2 for fail');
            $table->string('error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
