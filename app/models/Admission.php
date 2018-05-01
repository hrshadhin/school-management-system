<?php

class Admission extends \Eloquent {

	protected $table = 'admission';
	protected $fillable = ['stdName','nationality','class','session','dob','photo','campus','keeping','fatherName','fatherCellNo','motherName','motherCellNo'];

}
