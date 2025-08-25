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
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_name',150)->nullable();
            $table->string('coupon_code',150)->nullable();
            $table->text('coupon_description')->nullable();
            $table->json('product_id')->nullable();
            $table->json('cannot_applied_product_id')->nullable();
            $table->float('coupon_amount', 8, 2);
            $table->float('min_amount')->nullable();
            $table->boolean('coupon_type')->default(0)->comment('0 for flat 1 for %');
            $table->boolean('is_lifetime')->default(0)->comment('0 for No 1 for Yes');
            $table->boolean('is_once_per_user')->default(0)->comment('0 for No 1 for Yes');
            $table->boolean('is_active')->default(1)->comment('0 for inactive 1 for active');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('max_uses')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_coupons');
    }
};
