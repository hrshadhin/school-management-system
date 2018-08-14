<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            //name
            //guardian later feature
            // dob
            // gender
            //blood gorup
            //geigion
            // email
            // phone
            // addre
            // country
            //class
            //section
            // Group
            // regi no
            // roll no
            // photo
            //extra
            // remarks
            // user account create

            // need registration table
            // need student info log table

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
