<?php

class Student extends \Eloquent {
	protected $table = 'Student';
	protected $fillable = ['regiNo',
	'fname',
	'lname',
	'gender',
	'religion',
	'bloodgroup',
	'nationality',
	'dob',
	'session',
	'class',
	'photo',
	'fatherName',
	'fatherCellNo',
	'motherName',
	'motherCellNo',
   'presentAddress',
   'parmanentAddress'
	];


}
