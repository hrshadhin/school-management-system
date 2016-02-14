<?php

class FeeCol extends \Eloquent {

	protected $table = 'stdBill';
	protected $fillable = ['billNo','class','regiNo','payableAmount','paidAmount','dueAmount','payDate'];
}
