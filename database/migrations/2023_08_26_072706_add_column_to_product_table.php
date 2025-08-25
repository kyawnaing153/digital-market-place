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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_offer')->default(0)->comment('1 product offer Yes 2 for sale');
            $table->float('offer_price')->nullable();
            $table->timestamp('start_offer')->nullable();
            $table->timestamp('end_offer')->nullable();
            $table->integer('sale_count')->default(0)->nullable();
            $table->float('rating')->default(0)->nullable();
            $table->text('short_desc')->nullable();
            $table->longtext('product_details')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
