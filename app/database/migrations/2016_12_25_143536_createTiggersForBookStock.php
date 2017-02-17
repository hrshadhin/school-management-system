<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiggersForBookStock extends Migration {

	/**
	* Run the migrations.
	*
	* @return void
	*/
	public function up()
	{

			//book addd trigger
			DB::unprepared('
			CREATE TRIGGER `afterBookAdd` AFTER INSERT ON `Books` FOR EACH ROW
			BEGIN
			insert into bookStock
			set
			code = new.code,
			quantity = new.quantity;
			END
			');
			//after book delete
			DB::unprepared('
			CREATE TRIGGER `afterBookDelete` AFTER DELETE ON `Books` FOR EACH ROW
			BEGIN
			delete from issueBook where code = old.code;
			delete from bookStock where code = old.code;
			END
			');
			//afeter book update
			DB::unprepared('
			CREATE TRIGGER `afterBookUpdate` AFTER UPDATE ON `Books` FOR EACH ROW
			BEGIN
			UPDATE bookStock
			set
			quantity = new.quantity-(old.quantity-quantity)
			WHERE code=old.code;
			END
			');
			//after borrow book add
			DB::unprepared('
			CREATE TRIGGER `afterBorrowBookAdd` AFTER INSERT ON `issueBook` FOR EACH ROW
			BEGIN
			UPDATE bookStock
			set quantity = quantity-new.quantity
			where code=new.code;
			END
			');
			//after borrow book delete
			DB::unprepared("
			CREATE TRIGGER `afterBorrowBookDelete` AFTER DELETE ON `issueBook` FOR EACH ROW
			IF (old.Status='Borrowed') THEN
			UPDATE bookStock
			set quantity = quantity+old.quantity
			WHERE code=old.code;
			END IF
			");
			//after borrow book update
			DB::unprepared("
			CREATE TRIGGER `afterBorrowBookUpdate` AFTER UPDATE ON `issueBook` FOR EACH ROW
			IF (new.Status='Returned') THEN
			UPDATE bookStock
			set quantity = quantity+new.quantity
			WHERE code=new.code;
			END IF
			");


	}

	/**
	* Reverse the migrations.
	*
	* @return void
	*/
	public function down()
	{
		DB::unprepared('DROP IF EXISTS TRIGGER `afterBookAdd`');
		DB::unprepared('DROP IF EXISTS TRIGGER `afterBookDelete`');
		DB::unprepared('DROP IF EXISTS TRIGGER `afterBookUpdate`');
		DB::unprepared('DROP IF EXISTS TRIGGER `afterBorrowBookAdd`');
		DB::unprepared("DROP IF EXISTS TRIGGER `afterBorrowBookDelete`");
		DB::unprepared("DROP IF EXISTS TRIGGER `afterBorrowBookUpdate`");
	}

}
