<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->enum('type', [1,2,3])->default(1);
            $table->unsignedInteger('class_id');
            $table->enum('status', [0,1])->default(1);
            $table->unsignedSmallInteger('order')->default(0);
            $table->boolean('exclude_in_result')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();

            $table->foreign('class_id')->references('id')->on('i_classes');
        });

        // create the history table
        Schema::dropIfExists('subject_history');
        DB::unprepared("CREATE TABLE subject_history LIKE subjects;");
        // alter table
        DB::unprepared("ALTER TABLE subject_history MODIFY COLUMN id int(11) NOT NULL, 
   DROP PRIMARY KEY, ENGINE = MyISAM, ADD action VARCHAR(8) DEFAULT 'insert' FIRST, 
   ADD revision INT(6) NOT NULL AUTO_INCREMENT AFTER action,
   ADD PRIMARY KEY (id, revision);");

        DB::unprepared("DROP TRIGGER IF EXISTS subject_ai;");
        DB::unprepared("DROP TRIGGER IF EXISTS subject_au;");
        //create after insert trigger
        DB::unprepared("CREATE TRIGGER subject_ai AFTER INSERT ON subjects FOR EACH ROW
    INSERT INTO subject_history SELECT 'insert', NULL, d.* 
    FROM subjects AS d WHERE d.id = NEW.id;");
        DB::unprepared("CREATE TRIGGER subject_au AFTER UPDATE ON subjects FOR EACH ROW
    INSERT INTO subject_history SELECT 'update', NULL, d.*
    FROM subjects AS d WHERE d.id = NEW.id;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS subject_ai;");
        DB::unprepared("DROP TRIGGER IF EXISTS subject_au;");
        Schema::dropIfExists('subject_history');
        Schema::dropIfExists('subjects');
    }
}
