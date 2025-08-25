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
        Schema::table('products', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->comment('0 pending , 1 for accept ,2 for review, 3 for soft reject, 4 hard reject');
            $table->longtext('note')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('last_modified')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
