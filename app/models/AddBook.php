<?php

class AddBook extends \Eloquent {
	protected $table = 'Books';
	protected $fillable = ['code','title','author','rackNo','rowNo','type','class','desc'];
}
