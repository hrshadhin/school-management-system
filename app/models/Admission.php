<?php

class Admission extends \Eloquent {

	protected $table = 'admission';
	protected $fillable = ['stdName',
        'nationality',
        'class',
        'session',
        'dob',
        'photo',
        'fatherName',
        'fatherCellNo',
        'motherName',
        'motherCellNo',
        'signature',
        'address'
    ];

}
