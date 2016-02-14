<?php

class Attendance extends \Eloquent {
    protected $table = 'Attendance';
    protected $fillable = ['regiNo','subject','date','class','section','session','shift','status'];
}