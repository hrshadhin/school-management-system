<?php

class Attendance extends \Eloquent {
  protected $dates = ['date','created_at'];
  protected $table = 'Attendance';
  protected $fillable = ['student_regiNo','date','created_at'];
  public function student(){
    return $this->belongsTo('Student','regiNo');
  }

}
