<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title');
            $table->string('cat');
            $table->integer('property_price');
            $table->integer('rooms')->default(0);
            $table->integer('bedrooms')->default(0)->nullable();
            $table->integer('bathrooms')->default(0)->nullable();
            $table->integer('attached_bathrooms')->default(0)->nullable();
            $table->integer('common_bathrooms')->default(0)->nullable();
            $table->integer('kitchens')->nullable();
            $table->integer('balcony')->nullable();
            $table->string('gas')->nullable();
            $table->string('electricity');
            $table->string('advance');
            $table->string('furniture')->nullable();
            $table->string('swimming')->nullable();
            $table->string('parking')->nullable();
            $table->string('playground')->nullable();
            $table->string('photo');
            $table->string('applicant_type')->nullable();
            $table->mediumText('property_location');
            $table->longText('description');
            $table->string('phone_shared')->default('off');
            $table->integer('is_booked')->default(0);
            $table->integer('booked_by')->default(0);
            $table->integer('booking_expires')->default(0);
            $table->integer('expiry_unit')->default(-1);
            $table->timestamps();
        });
        /*
        Schema::table('listings', function (Blueprint $table) {
            //modify existing database table
            //$table->string('cat')->after('title');
            // run 'php artisan migrate'
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listings');
    }
}
