<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('username')->unique();
                $table->string('email')->unique();
                $table->string('password');
                $table->rememberToken();
                $table->boolean('force_logout')->default(0);
                $table->enum('status', [0,1])->default(1);
                $table->timestamps();
                $table->softDeletes();
                $table->userstamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
