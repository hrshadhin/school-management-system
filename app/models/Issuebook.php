<?php

class Issuebook extends \Eloquent {
	protected $table = 'issueBook';
	protected $fillable = ['regiNo','code','issueDate','returnDate','fine'];
}
