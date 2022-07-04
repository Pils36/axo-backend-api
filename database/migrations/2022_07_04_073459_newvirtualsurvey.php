<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Newvirtualsurvey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_virtual_survey', function (Blueprint $table) {
            $table->id();
            $table->uuid('survey_id');
            $table->string('movingFrom');
            $table->string('movingTo');
            $table->string('homeSize');
            $table->string('visitDate');
            $table->string('visitTime');
            $table->string('modeOfVisit');
            $table->string('address');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email');
            $table->string('howYouHearAboutUs');
            $table->string('additionalDetails')->nullable();
            $table->string('phoneNumber')->nullable();
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
        Schema::dropIfExists('new_virtual_survey');
    }
}