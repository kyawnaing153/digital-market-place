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
        Schema::create('contactus', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->string('name',50)->nullable();
            $table->string('email',50)->nullable();
            $table->text('message')->nullable();
            $table->string('type',50);
            $table->float('rating',50);
            $table->boolean('is_replay')->comment('1 for reply 0 for pending')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactus');
    }
};
