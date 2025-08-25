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
        Schema::table('order_products', function (Blueprint $table) {
            $table->bigInteger('vendor_id')->nullable();
            $table->double('admin_commission')->default(0);
            $table->double('vendor_amount')->default(0);
            $table->string('tax_rate')->default(0);
            $table->string('commission_rate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            //
        });
    }
};
