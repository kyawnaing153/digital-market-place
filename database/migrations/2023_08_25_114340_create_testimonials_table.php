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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->boolean('is_checked_designation')->default(1)->comment('1 for active 0 for inactive');;
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(1)->comment('1 for active 0 for inactive');
            $table->float('rating')->default(0);
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
