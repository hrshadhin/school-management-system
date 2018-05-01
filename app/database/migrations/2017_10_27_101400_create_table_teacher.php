<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTeacher extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('Teachers', function(Blueprint $table)
        {
            $table->string('regNo',255);
            $table->enum('egroup', ['Teacher', 'Staff'])->nullable();
            $table->string('fullName',255);
            $table->string('gender',10);
            $table->string('religion',15);
            $table->string('bloodgroup',10);
            $table->string('nationality',50);
            $table->string('dob',12);
            $table->string('joinDate',12);
            $table->string('photo',270);
            $table->string('educationQualification',30);
            $table->text('details')->nullable();
            $table->string('cellNo',15);
            $table->string('presentAddress',500);
            $table->string('parmanentAddress',500);
            $table->smallInteger('isActive')->default(1);
            $table->timestamps();
            $table->primary('regNo');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('Teachers');
	}

}
