<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSMSLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('smsLog', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('type',30);
            $table->string('sender',100);
            $table->string('recipient',15);
            $table->text('message');
            $table->string('regiNo');
            $table->string('status');
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
        Schema::drop('smsLog');
	}

}
