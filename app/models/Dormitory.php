<?php

class Dormitory extends \Eloquent {
	protected $table = 'dormitory';
	protected $fillable = ['name','numOfRoom','address','description'];
}
