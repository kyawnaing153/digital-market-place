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
        Schema::create('email_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('list_name')->nullable();
            $table->boolean('is_checked')->default(0)->comment('1 for Yes 0 for No');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_lists');
    }
};
