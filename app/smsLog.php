<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class smsLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'to', 'message', 'status',
    ];

}
