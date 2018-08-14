<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->enum('emp_type',[1,2]);
            $table->string('name');
            $table->string('designation');
            $table->string('dob',10);
            $table->enum('gender', [1,2])->default(1);
            $table->string('religion')->nullable();
            $table->string('email',100);
            $table->string('phone',15)->nullable();
            $table->string('address')->nullable();
            $table->string('joining_date',10);
            $table->string('photo')->nullable();
            $table->enum('status', [0,1])->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();


            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
