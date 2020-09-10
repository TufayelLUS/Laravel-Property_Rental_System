<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_title')->default('Laravel Web Application');
            $table->string('app_slogan')->default('Web Application Slogan');
            $table->string('fb_url')->default('https://www.facebook.com/');
            $table->string('twitter_url')->default('https://www.twitter.com/');
            $table->string('linkedin_url')->default('https://www.linkedin.com/');
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
        Schema::dropIfExists('app_configs');
    }
}
