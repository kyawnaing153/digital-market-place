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
        Schema::create('product_analyses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->nullable();
            $table->string('browser')->nullable();
            $table->string('device')->nullable();
            $table->string('ip_adress')->nullable();
            $table->string('page_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_analyses');
    }
};
