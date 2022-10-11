<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories
     *
     * For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
     * To not introduce additional complexity, please consider only one cinema.
     *
     * Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.
     *
     * ## User Stories
     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out
     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms
     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat
     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        /*list of tables
         * users
         * user roles
         * movies
         * shows
         * liveshows
         * showtimings
         * pricing
         * seats
         * seat_types
         * resercations
         * */
        Schema::create('users', function ($table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name', 100);
            $table->string('email', 255);
            $table->string('password', 255);
            $table->bigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('user_roles');
            $table->timestamps();
        });
        Schema::create('user_roles', function ($table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('rolename', 100);
            $table->timestamps();
        });
        Schema::create('movies', function ($table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name', 100);
            $table->string('short_description', 255);
            $table->timestamps();
        });
        Schema::create('shows', function ($table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('show_name', 100);
            $table->string('short_description', 255);
            $table->timestamps();
        });
        Schema::create('liveshows', function ($table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('movie_id')->unsigned();
            $table->index('movie_id');
            $table->bigInteger('show_id')->unsigned();
            $table->bigInteger('show_timing_id')->unsigned();
            $table->index('show_id');
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->foreign('show_timing_id')->references('id')->on('showtimings');
            $table->foreign('show_id')->references('id')->on('shows');
            $table->timestamps();
        });
        Schema::create('showtimings', function ($table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('show_start', 100);
            $table->string('show_end', 100);
            $table->timestamps();
        });
        Schema::create('pricing', function ($table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('seat_id')->unsigned();
            $table->bigInteger('show_timing_id')->unsigned();
            $table->foreign('seat_id')->references('id')->on('seats');
            $table->foreign('show_timing_id')->references('id')->on('showtimings');
            $table->index('seat_id');
            $table->timestamps();
        });
        Schema::create('seats', function ($table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('seat_number')->unsigned();
            $table->bigInteger('seat_type_id')->unsigned();
            $table->foreign('seat_type_id')->references('id')->on('seat_types');
            $table->index('seat_type_id');
            $table->timestamps();
        });
        Schema::create('seat_types', function ($table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('type_name', 100);
            $table->timestamps();
        });
        Schema::create('reservations', function ($table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('princing_id')->unsigned();
            $table->foreign('princing_id')->references('id')->on('pricing');
            $table->foreign('user_id')->references('id')->on('users');
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
    }
}
