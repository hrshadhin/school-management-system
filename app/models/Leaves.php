<?php

class Leaves extends \Eloquent {
    protected $table = 'Leaves';

    protected $dates=['leaveDate'];

    protected $fillable = [
        'regNo',
        'lType',
        'leaveDate',
        'description',
        'paper',
        'status',
    ];

    public function teacher(){

        return $this->belongsTo('Teachers','regNo');
    }
}
