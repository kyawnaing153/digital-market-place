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
        Schema::create('products', function (Blueprint $table){
            $table->id();
            $table->string('product_type',25)->nullale();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('tags')->nullable();
            $table->longtext('description')->nullable();
            $table->integer('quantity')->default(0)->nullable();
            $table->string('preview_link')->nullable();
            $table->string('uploaded_by')->nullable();
            $table->double('price')->nullable();
            $table->boolean('is_enable_multi_price')->default(0)->comment('1 for Yes 0 for No');
            $table->tinyInteger('file_type')->default(0)->comment('0 for single 1 for Bundle');
            $table->string('file_name')->nullable();
            $table->string('file_url')->nullable();
            $table->string('file_open_pass')->nullable();
            $table->integer('coupon_id')->nullable();
            $table->boolean('is_active')->default(1)->comment('1 for active 0 for inactive');
            $table->boolean('is_free')->default(0)->comment('1 for free 0 for No');
            $table->boolean('is_preview')->default(0)->comment('1 for Yes 0 for No');
            $table->boolean('is_featured')->default(0)->comment('1 for Yes 0 for No');
            $table->string('meta_title',100)->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_desc',200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
