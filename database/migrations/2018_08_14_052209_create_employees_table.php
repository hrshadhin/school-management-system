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
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('role_id');
            $table->string('id_card',50)->unique();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('qualification')->nullable();
            $table->string('dob',10);
            $table->enum('gender', [1,2])->default(1);
            $table->enum('religion', [1,2,3,4,5])->default(1);;
            $table->string('email',100)->nullable();
            $table->string('phone_no',15)->nullable();
            $table->string('address',500)->nullable();
            $table->string('joining_date',10);
            $table->string('photo')->nullable();
            $table->string('signature')->nullable();
            $table->enum('shift', [1,2])->default(1);
            $table->time('duty_start')->nullable();
            $table->time('duty_end')->nullable();
            $table->enum('status', [0,1])->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('employees');
//        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
