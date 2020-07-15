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
            $table->unsignedInteger('user_id')->nullable();
            $table->string('name');
            $table->string('nick_name',50)->nullable();
            $table->string('dob',10);
            $table->enum('gender', [1,2])->default(1);
            $table->string('religion')->nullable();
            $table->string('blood_group',10)->nullable();
            $table->string('nationality',50)->nullable();
            $table->string('photo')->nullable();
            $table->string('email',100)->nullable();
            $table->string('phone_no')->nullable();
            $table->string('extra_activity')->nullable();
            $table->string('note',500)->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_phone_no',15)->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_phone_no',15)->nullable();
            $table->string('guardian')->nullable();
            $table->string('guardian_phone_no',15)->nullable();
            $table->string('present_address',500)->nullable();
            $table->string('permanent_address',500);
            $table->smallInteger('sms_receive_no')->default(1); //0=none,1=father,2=mother,3=guardian
            $table->string('siblings')->nullable();
            $table->string('signature')->nullable();
            $table->enum('status', [0,1])->default(1);



            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();

        });
        Schema::create('student_info_log', function (Blueprint $table) {
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('academic_year_id');
            $table->string('meta_key');
            $table->text('meta_value')->nullable();
            $table->dateTime('created_at');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('academic_year_id')->references('id')->on('academic_years');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_info_log');
        Schema::dropIfExists('students');
    }
}
