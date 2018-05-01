<?php

class Workoutside extends \Eloquent {
    protected $table = 'WorkOutside';

    protected $dates=['workDate'];

    protected $fillable = [
        'regNo',
        'workDate',
        'description',
        'paper',
        'status',
    ];

    public function teacher(){

        return $this->belongsTo('Teachers','regNo');
    }
}
