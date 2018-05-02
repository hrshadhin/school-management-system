<?php

class Teachers extends \Eloquent {
    protected $table = 'Teachers';

    protected $fillable = [
        'regNo',
        'egroup',
        'fullName',
        'gender',
        'religion',
        'bloodgroup',
        'nationality',
        'dob',
        'joinDate',
        'photo',
        'details',
        'cellNo',
        'presentAddress',
        'parmanentAddress',
        'isActive',
    ];
    protected $primaryKey = 'regNo';

//    public function attendance(){
//        return $this->hasMany('TeacherAttendance','regNo');
//    }

}
