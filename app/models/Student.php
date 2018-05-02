<?php


class Student extends \Eloquent
{
    protected $table = 'Student';
    protected $fillable = ['regiNo',
    'firstName',
    'lastName',
    'middleName',
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
    'parmanentAddress',
    'fourthSubject',
    'cphsSubject'
    ];
    protected $primaryKey = 'id';
    public function attendance()
    {
        $this->primaryKey = "regiNo";
        return $this->hasMany('Attendance', 'regiNo');
    }
    

}
