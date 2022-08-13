<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('numeric_value');
            $table->integer('order')->default(0);
            $table->string('group',20)->nullable();
            $table->unsignedTinyInteger('duration')->default(1);
            $table->boolean('have_selective_subject')->default(false);
            $table->unsignedTinyInteger('max_selective_subject')->nullable();
            $table->boolean('have_elective_subject')->default(false);
            $table->text('note')->nullable();
            $table->boolean('is_open_for_admission')->default(false);
            $table->enum('status', [0,1])->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();


        });

        // create the history table
        Schema::dropIfExists('i_class_history');
        DB::unprepared("CREATE TABLE i_class_history LIKE i_classes;");
        // alter table
        DB::unprepared("ALTER TABLE i_class_history MODIFY COLUMN id int(11) NOT NULL, 
   DROP PRIMARY KEY, ENGINE = MyISAM, ADD action VARCHAR(8) DEFAULT 'insert' FIRST, 
   ADD revision INT(6) NOT NULL AUTO_INCREMENT AFTER action,
   ADD PRIMARY KEY (id, revision);");

        DB::unprepared("DROP TRIGGER IF EXISTS i_class__ai;");
        DB::unprepared("DROP TRIGGER IF EXISTS i_class__au;");
        //create after insert trigger
        DB::unprepared("CREATE TRIGGER i_class__ai AFTER INSERT ON i_classes FOR EACH ROW
    INSERT INTO i_class_history SELECT 'insert', NULL, d.* 
    FROM i_classes AS d WHERE d.id = NEW.id;");
        DB::unprepared("CREATE TRIGGER i_class__au AFTER UPDATE ON i_classes FOR EACH ROW
    INSERT INTO i_class_history SELECT 'update', NULL, d.*
    FROM i_classes AS d WHERE d.id = NEW.id;");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS i_class__ai;");
        DB::unprepared("DROP TRIGGER IF EXISTS i_class__au;");
        Schema::dropIfExists('i_class_history');
        Schema::dropIfExists('i_classes');
    }
}
