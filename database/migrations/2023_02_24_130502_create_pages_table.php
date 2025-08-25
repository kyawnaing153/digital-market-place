<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->string('heading',200)->nullable();
            $table->string('sub_heading')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_active')->default(1)->comment('1 for active 0 for inactive');
            $table->string('meta_title',100)->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_desc',200)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Pages');
    }
};
