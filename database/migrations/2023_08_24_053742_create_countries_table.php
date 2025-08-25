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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('short_name',25)->nullable();
            $table->string('currency',100)->nullable();
            $table->string('currency_code',25)->nullable();
            $table->string('symbol',25)->nullable();
            $table->string('thousand_separator',10)->nullable();
            $table->string('decimal_separator',10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
