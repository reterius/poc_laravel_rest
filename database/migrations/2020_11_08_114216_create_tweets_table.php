<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tweet_content');
            $table->timestamp('writed_at')->nullable();
            $table->integer('user_id')->unsigned(); 
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('tweet_link');
            $table->unique('tweet_link');
            $table->enum('tweet_status', ['0', '1'])->default('0');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*         
        $table->dropForeign('tweets_user_id_foreign');
        $table->dropIndex('tweets_user_id_index');
        $table->dropColumn('user_id');
         */
        Schema::dropIfExists('tweets');
    }
}
