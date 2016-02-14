<?php

class FeeSetup extends \Eloquent {
	protected $table = 'feesSetup';
	protected $fillable = ['class','type','title','fee','Latefee','description'];
}
