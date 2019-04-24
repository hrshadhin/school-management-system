<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hrshadhin\Userstamps\UserstampsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceFileQueue extends Model
{
    use SoftDeletes;
    use UserstampsTrait;


    protected $fillable = [
        'file_name',
        'client_file_name',
        'file_format',
        'total_rows',
        'imported_rows',
        'send_sms',
        'is_imported',
        'send_notification',
        'attendance_type',
    ];

}
