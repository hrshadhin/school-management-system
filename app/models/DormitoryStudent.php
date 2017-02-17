<?php

class DormitoryStudent extends \Eloquent {
	protected $table = 'dormitory_student';
	protected $fillable = ['regiNo','joinDate','leaveDate','dormitory','roomNo','monthlyFee','isActive'];
}
