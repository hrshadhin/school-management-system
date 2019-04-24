<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceFileQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_file_queues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name');
            $table->string('client_file_name');
            $table->integer('file_format')->default(0);
            $table->integer('total_rows');
            $table->integer('imported_rows');
            $table->smallInteger('is_imported')->default(0);
            $table->smallInteger('send_notification')->default(0);
            $table->enum('attendance_type',[1,2])->default(1); //1=student 2=employee
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_file_queues');
    }
}
