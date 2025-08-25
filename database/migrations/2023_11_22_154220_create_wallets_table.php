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
        Schema::create('wallets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('user_id')->nullable();
            $table->string('type')->nullable();
            $table->double('credit')->default(0);
            $table->double('debit')->default(0);
            $table->tinyInteger('status')->default(0)->comment('0 for pending 1 for accept 2 for reject');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
