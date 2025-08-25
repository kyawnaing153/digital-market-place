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
        Schema::create('email_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('is_active')->default(1)->comment('1 for active 0 for inactive');
            $table->boolean('is_connect')->default(0)->comment('1 for Yes 0 for No');
            $table->text('credentials');
            $table->timestamps();

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_providers');
    }
};
