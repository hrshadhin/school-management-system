<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceSmsQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_sms_queues', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('attendance_file_queue_id');
            $table->date('att_date');
            $table->string('class_code');
            $table->string('class_name');
            $table->integer('total_absent');
            $table->integer('send_sms')->default(0);
            $table->smallInteger('is_complete')->default(0);
            $table->timestamps();

            $table->foreign('attendance_file_queue_id')->references('id')->on('attendance_file_queues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_sms_queues');
    }
}
