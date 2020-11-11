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
            $table->string('fullname', 30)->nullable(false);
            $table->string('email', 256)->nullable(false);
            $table->string('password', 128)->nullable(false);
            $table->string('phone', 20)->nullable(false);
            $table->string('twitter_name', 20)->nullable(false);
            $table->string('email_act_code', 64)->nullable(true);
            $table->enum('email_act_status', ['0', '1'])->default('0');
            $table->unique('email');
            $table->unique('email_act_code');
            $table->string('access_token')->nullable(true);

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
