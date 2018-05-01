<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStudent extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Student', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('regiNo',20);
            $table->string('rollNo',20);
            $table->string('session',15);
            $table->string('class',100);
            $table->string('group',15);
            $table->string('section',2);
            $table->string('shift',15);

            $table->string('firstName',60);
            $table->string('middleName',60);
            $table->string('lastName',60);
            $table->string('gender',10);
            $table->string('religion',15);
            $table->string('bloodgroup',10);
            $table->string('nationality',50);
            $table->string('dob',12);
            $table->string('photo',30);
            $table->string('extraActivity',150);
            $table->string('remarks',250);

            $table->string('fatherName',180);
            $table->string('fatherCellNo',15);
            $table->string('motherName',180);
            $table->string('motherCellNo',15);
            $table->string('localGuardian',180);
            $table->string('localGuardianCell',15);
            $table->string('presentAddress',500);
            $table->string('parmanentAddress',500);
            $table->string('isActive',10);
            $table->string('fourthSubject',255)->nullable();
            $table->string('cphsSubject',255)->nullable();
            $table->timestamps();
            $table->index('regiNo');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Student');
    }

}
