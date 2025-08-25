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
        Schema::create('home_contents', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('heading')->nullable();
            $table->string('sub_heading')->nullable();
            $table->string('link')->nullable();
            $table->string('type')->nullable();
            $table->string('page_name',50)->nullable();
            $table->boolean('is_active')->default(1)->comment('0 for inactive 1 for active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_contents');
    }
};
