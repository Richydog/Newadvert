<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100);
            $table->string('last_name',100)->nullable();
            $table->string('email',100)->unique();
            $table->string('phone',30)->nullable();
            $table->boolean('phone_verified')->default(0);
            $table->string('phone_verify_token',100)->nullable();
            $table->timestamp('phone_verify_token_expire')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',100);
            $table->string('role',16)->default('user');
            $table->rememberToken();
            $table->timestamps();




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
