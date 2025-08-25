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
        Schema::create('vendor_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->text('answers')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 for pending 1 for accept 2 for reject');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_requests');
    }
};
