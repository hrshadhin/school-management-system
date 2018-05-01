<?php

class Holidays extends \Eloquent {
    protected $table = 'Holidays';
    protected $dates =['holiDate','createdAt'];
    public $timestamps = false;
    protected $fillable = [
        'holiDate',
        'description',
        'status',
    ];
}
