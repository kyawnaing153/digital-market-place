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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('role')->comment('role 0 for admin , 1 for user , 2 for vendor');
            $table->string('role_type')->comment('ADMIN,USER,VENDOR');
            $table->string('avatar')->default('')->nullable();
            $table->string('username',100)->default('')->nullable();
            $table->string('full_name',150)->default('')->nullable();
            $table->string('gender',15)->default('')->nullable();
            $table->string('email',100)->nullable();
            $table->string('password')->nullable();
            $table->string('mobile',15)->default('')->nullable();
            $table->timestamp('birthday')->nullable();
            $table->string('address')->default('')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('city')->default('')->nullable();
            $table->string('state')->default('')->nullable();
            $table->string('zip_code')->default('')->nullable();
            $table->boolean('is_active')->default('1')->nullable();
            $table->boolean('is_email_verified')->default('0')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_mobile_verified')->default('0')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->tinyInteger('rating')->default('0')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
