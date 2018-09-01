<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('capacity');
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('teacher_id');
            $table->text('note')->nullable();
            $table->enum('status', [0,1])->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();

            $table->foreign('class_id')->references('id')->on('i_classes');
            $table->foreign('teacher_id')->references('id')->on('employees');

        });

        // create the history table
        Schema::dropIfExists('section_history');
        DB::unprepared("CREATE TABLE section_history LIKE sections;");
        // alter table
        DB::unprepared("ALTER TABLE section_history MODIFY COLUMN id int(11) NOT NULL, 
   DROP PRIMARY KEY, ENGINE = MyISAM, ADD action VARCHAR(8) DEFAULT 'insert' FIRST, 
   ADD revision INT(6) NOT NULL AUTO_INCREMENT AFTER action,
   ADD PRIMARY KEY (id, revision);");

        DB::unprepared("DROP TRIGGER IF EXISTS section__ai;");
        DB::unprepared("DROP TRIGGER IF EXISTS section__au;");
        //create after insert trigger
        DB::unprepared("CREATE TRIGGER section__ai AFTER INSERT ON sections FOR EACH ROW
    INSERT INTO section_history SELECT 'insert', NULL, d.* 
    FROM sections AS d WHERE d.id = NEW.id;");
        DB::unprepared("CREATE TRIGGER section__au AFTER UPDATE ON sections FOR EACH ROW
    INSERT INTO section_history SELECT 'update', NULL, d.*
    FROM sections AS d WHERE d.id = NEW.id;");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS section__ai;");
        DB::unprepared("DROP TRIGGER IF EXISTS section__au;");
        Schema::dropIfExists('section_history');
        Schema::dropIfExists('sections');
    }
}
