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
        Schema::create('ratings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->foreignUuid('parent_id')->nullable();
            $table->tinyInteger('rating')->default(0)->nullable();
            $table->text('comment')->nullable();
            $table->boolean('is_active')->default(1)->comment('1 for active 0 for inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
