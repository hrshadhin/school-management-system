<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceSmsQueue extends Model
{
    protected $fillable = [
        'attendance_file_queue_id',
        'att_date','class_name',
        'class_code',
        'total_absent',
        'send_sms', 'is_complete'
    ];

}
